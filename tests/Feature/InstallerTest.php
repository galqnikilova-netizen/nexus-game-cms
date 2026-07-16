<?php

namespace Tests\Feature;

use Tests\TestCase;

class InstallerTest extends TestCase
{
    public function test_installer_route_is_registered(): void
    {
        $this->assertTrue(app('router')->has('install'));
        $this->assertTrue(app('router')->has('install.store'));
    }
}
