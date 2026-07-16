<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppearanceSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_changes_are_rendered_in_public_and_admin_themes(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $this->actingAs($owner)->put(route('admin.settings.update'), [
            'site_name' => 'MONITOR X', 'site_tagline' => 'Premium network',
            'default_locale' => 'en', 'accent_color' => '#49a6ff',
        ])->assertRedirect();
        $this->get('/')->assertOk()->assertSee('MONITOR X')->assertSee('--accent:#49a6ff', false);
        $this->get(route('admin.settings.edit'))->assertOk()->assertSee('#49a6ff');
    }

    public function test_navigation_language_switch_updates_authenticated_user(): void
    {
        $user = User::factory()->create(['locale' => 'bg']);
        $this->actingAs($user)->get('/locale/en')->assertRedirect();
        $this->assertSame('en', $user->fresh()->locale);
        $this->get('/')->assertSee('Your community.')->assertSee('Home');
    }
}
