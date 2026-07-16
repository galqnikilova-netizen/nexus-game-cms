<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameServer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GameServerController extends Controller
{
    public function index(): View { return view('admin.servers.index', ['servers' => GameServer::orderBy('sort_order')->paginate(20)]); }
    public function create(): View { return view('admin.servers.form', ['server' => new GameServer]); }
    public function store(Request $request): RedirectResponse { GameServer::create($this->validated($request)); return to_route('admin.servers.index')->with('success', 'Сървърът е добавен.'); }
    public function edit(GameServer $server): View { return view('admin.servers.form', compact('server')); }
    public function update(Request $request, GameServer $server): RedirectResponse { $server->update($this->validated($request, $server)); return to_route('admin.servers.index')->with('success', 'Сървърът е обновен.'); }
    public function destroy(GameServer $server): RedirectResponse { $server->delete(); return back()->with('success', 'Сървърът е премахнат.'); }
    private function validated(Request $request, ?GameServer $server = null): array
    {
        $data = $request->validate(['name'=>['required','string','max:120'],'game'=>['required','in:cs2,cs16,minecraft'],'host'=>['required','string','max:255'],'port'=>['required','integer','between:1,65535'],'query_port'=>['nullable','integer','between:1,65535'],'rcon_password'=>['nullable','string','max:255'],'is_visible'=>['nullable','boolean'],'sort_order'=>['nullable','integer','min:0']]);
        $data['slug'] = $server?->slug ?? Str::slug($data['name']).'-'.Str::lower(Str::random(5)); $data['is_visible']=$request->boolean('is_visible');
        if (($data['rcon_password'] ?? '') === '' && $server) unset($data['rcon_password']);
        return $data;
    }
}

