<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase; use Tests\TestCase;
class LocalizationTest extends TestCase { use RefreshDatabase; public function test_language_switch_persists():void { $this->get('/locale/en')->assertRedirect(); $this->get('/')->assertOk()->assertSee('GAME COMMUNITY'); $this->get('/locale/bg')->assertRedirect(); $this->get('/')->assertOk()->assertSee('GAME COMMUNITY'); } }
