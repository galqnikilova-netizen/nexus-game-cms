<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class PageController extends Controller
{
    public function community(): View
    {
        return view('community', ['members' => User::query()->latest()->limit(8)->get(), 'memberCount' => User::count()]);
    }

    public function shop(): View
    {
        return view('shop');
    }
}
