<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('news.index', ['posts' => NewsPost::published()->latest('published_at')->paginate(9)]);
    }

    public function show(NewsPost $news): View
    {
        abort_unless($news->is_published && $news->published_at?->lte(now()), 404);
        return view('news.show', compact('news'));
    }
}
