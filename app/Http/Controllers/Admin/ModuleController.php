<?php
namespace App\Http\Controllers\Admin; use App\Http\Controllers\Controller; use App\Models\Module; use App\Services\ModuleManager; use Illuminate\Http\RedirectResponse; use Illuminate\View\View;
class ModuleController extends Controller { public function index(ModuleManager $manager):View{$manager->discover();return view('admin.modules.index',['modules'=>Module::orderBy('name')->get()]);} public function toggle(Module $module,ModuleManager $manager):RedirectResponse{$manager->toggle($module);return back()->with('success',$module->enabled?'Модулът е включен.':'Модулът е изключен.');} }
