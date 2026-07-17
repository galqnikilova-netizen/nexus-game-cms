<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function community(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $members = User::query()
            ->when($search !== '', fn ($query) => $query->where(fn ($match) => $match
                ->where('name', 'like', "%{$search}%")
                ->orWhere('steam_id', 'like', "%{$search}%")))
            ->latest()->limit(24)->get();

        return view('community', ['members' => $members, 'memberCount' => User::count(), 'search' => $search]);
    }

    public function shop(): View
    {
        return view('shop');
    }

    public function about(): View { return view('about'); }
}
