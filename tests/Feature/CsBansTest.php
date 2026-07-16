<?php

namespace Tests\Feature;

use App\Services\CsBansService;
use Tests\TestCase;

class CsBansTest extends TestCase
{
    public function test_disabled_integration_renders_safe_setup_state(): void
    {
        config(['csbans.enabled' => false]);
        $this->get('/bans')->assertOk()->assertSee('CSBans връзката не е конфигурирана')->assertSee('portal-ban-page');
    }

    public function test_ban_status_matches_csbans_conventions(): void
    {
        $service = app(CsBansService::class);
        $base = ['ban_created' => time() - 60, 'expired' => 0, 'ban_reason' => '<b>Cheating</b>'];
        $permanent = $service->present((object) ($base + ['ban_length' => 0]));
        $unbanned = $service->present((object) ($base + ['ban_length' => -1]));
        $this->assertTrue($permanent->is_active);
        $this->assertTrue($permanent->is_permanent);
        $this->assertFalse($unbanned->is_active);
        $this->assertSame('Cheating', $permanent->safe_reason);
    }
}
