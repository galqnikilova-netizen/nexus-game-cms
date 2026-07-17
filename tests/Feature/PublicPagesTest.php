<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    public function test_public_pages_are_reachable(): void
    {
        foreach (['/', '/leaderboard', '/store', '/skinchanger', '/punishments', '/faq', '/rules', '/tickets', '/players/STEAM_1:1:20482001'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }
}
