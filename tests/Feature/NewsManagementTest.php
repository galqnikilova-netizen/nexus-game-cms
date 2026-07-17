<?php

namespace Tests\Feature;

use App\Models\NewsPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_create_and_publish_news(): void
    {
        $owner = User::factory()->create(['role'=>'owner']);
        $this->actingAs($owner)->post(route('admin.news.store'), [
            'title'=>'NEXUS Update', 'excerpt'=>'Кратко описание на новината.',
            'content'=>'Пълно съдържание на публикацията.', 'category'=>'Platform',
            'is_published'=>'1', 'is_featured'=>'1',
        ])->assertRedirect(route('admin.news.index'));

        $post = NewsPost::firstOrFail();
        $this->get(route('news.index'))->assertOk()->assertSee('NEXUS Update');
        $this->get(route('news.show',$post))->assertOk()->assertSee('Пълно съдържание');
        $this->get('/')->assertOk()->assertSee('NEXUS Update');
    }

    public function test_drafts_are_not_public(): void
    {
        $post = NewsPost::create(['title'=>'Draft','slug'=>'draft','excerpt'=>'Hidden','content'=>'Hidden body','category'=>'News','is_published'=>false]);
        $this->get(route('news.show',$post))->assertNotFound();
    }
}
