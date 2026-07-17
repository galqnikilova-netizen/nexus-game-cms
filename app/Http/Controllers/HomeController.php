<?php

namespace App\Http\Controllers;

use App\Models\GameServer;
use App\Models\NewsPost;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $servers = GameServer::query()->where('is_visible', true)->orderBy('sort_order')->limit(4)->get();
        $posts = NewsPost::published()->latest('published_at')->limit(3)->get();
        return view('home', compact('servers', 'posts'));
    }
}
