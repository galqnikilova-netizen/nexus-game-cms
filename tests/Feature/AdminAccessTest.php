<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_and_owner_can_open_dashboard(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $owner = User::factory()->create(['role'=>'owner']);
        $this->actingAs($owner)->get('/admin')->assertOk()->assertSee('Добре дошъл обратно');
    }
}

