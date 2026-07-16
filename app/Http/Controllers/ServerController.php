<?php

namespace App\Http\Controllers;

use App\Models\GameServer;
use Illuminate\View\View;

class ServerController extends Controller
{
    public function index(): View
    {
        $servers = GameServer::query()->where('is_visible', true)->orderByDesc('status')->orderByDesc('players_online')->paginate(18);
        return view('servers.index', compact('servers'));
    }
}

