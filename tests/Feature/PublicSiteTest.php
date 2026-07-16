<?php

namespace Tests\Feature;

use App\Models\GameServer;
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
    }
}

