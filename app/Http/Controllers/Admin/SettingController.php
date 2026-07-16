<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', ['settings' => Setting::query()->pluck('value', 'key')]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:80'],
            'site_tagline' => ['nullable', 'string', 'max:160'],
            'default_locale' => ['required', 'in:bg,en'],
            'accent_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);
        $keys = ['site_name' => 'site.name', 'site_tagline' => 'site.tagline', 'default_locale' => 'default.locale', 'accent_color' => 'accent.color'];
        foreach ($keys as $input => $key) Setting::updateOrCreate(['key' => $key], ['value' => $data[$input] ?? '', 'is_public' => true]);
        return back()->with('success', 'Настройките са приложени към сайта и контролния панел.');
    }
}
