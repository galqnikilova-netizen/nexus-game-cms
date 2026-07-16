<?php

namespace Tests\Feature;

use App\Models\GameServer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_and_server_browser_render(): void
    {
        GameServer::create(['name'=>'NEXUS Competitive','slug'=>'nexus-competitive','game'=>'cs2','host'=>'127.0.0.1','port'=>27015,'is_visible'=>true]);
        $this->get('/')->assertOk()->assertSee('NEXUS Competitive');
        $this->get('/servers')->assertOk()->assertSee('NEXUS Competitive');
        $this->get('/community')->assertOk()->assertSee('OUR COMMUNITY')->assertSee('portal-page-grid');
        $this->get('/shop')->assertOk()->assertSee('PRIME VIP')->assertSee('portal-page-grid');
        $this->get('/bans')->assertOk()->assertSee('portal-subhead')->assertSee('portal-page-grid');
        $this->get('/')->assertSee(route('community.index'))->assertSee(route('shop.index'))->assertSee(route('bans.index'));
        $this->get('/')->assertSee('mobile-menu')->assertSee('portal-nav')->assertSee('portal-columns');
    }

    public function test_shop_renders_for_authenticated_members(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/shop')
            ->assertOk()
            ->assertSee('0.00 EUR');
    }
}
