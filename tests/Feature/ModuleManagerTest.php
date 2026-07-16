<?php
namespace Tests\Feature;
use App\Models\Module; use App\Models\User; use App\Services\ModuleManager; use Illuminate\Foundation\Testing\RefreshDatabase; use Tests\TestCase;
class ModuleManagerTest extends TestCase { use RefreshDatabase; public function test_manifest_is_discovered_and_owner_can_toggle_module():void { app(ModuleManager::class)->discover(); $module=Module::where('slug','server-monitor')->firstOrFail(); $owner=User::factory()->create(['role'=>'owner']); $this->actingAs($owner)->patch(route('admin.modules.toggle',$module))->assertRedirect(); $this->assertTrue($module->fresh()->enabled); } }
