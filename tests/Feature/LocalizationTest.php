<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase; use Tests\TestCase;
class LocalizationTest extends TestCase { use RefreshDatabase; public function test_language_switch_persists_and_translates_homepage():void { $this->get('/locale/en')->assertRedirect(); $this->get('/')->assertOk()->assertSee('Your community.'); $this->get('/locale/bg')->assertRedirect(); $this->get('/')->assertOk()->assertSee('Твоята общност.'); } }
