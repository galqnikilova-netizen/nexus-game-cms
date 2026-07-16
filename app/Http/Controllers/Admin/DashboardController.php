<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameServer;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = ['users' => User::count(), 'servers' => GameServer::count(), 'online' => GameServer::where('status','online')->count(), 'players' => GameServer::sum('players_online')];
        $servers = GameServer::orderBy('sort_order')->limit(8)->get();
        return view('admin.dashboard', compact('stats', 'servers'));
    }
}

