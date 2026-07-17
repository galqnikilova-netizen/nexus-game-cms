<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}" data-bs-theme="dark">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="csrf-token" content="{{ csrf_token() }}"><title>{{ $title ?? $nexusAppearance['site_name'] }}</title><meta name="description" content="{{ $nexusAppearance['site_tagline'] }}"><meta name="theme-color" content="#0b0e14">@vite(['resources/css/app.css','resources/js/app.js'])</head>
<body class="n2-public" style="--accent:{{ $nexusAppearance['accent'] }};--accent2:{{ $nexusAppearance['accent'] }}">
<div class="n2-statusbar"><div class="n2-container"><span><i></i> NEXUS NETWORK ONLINE</span><div><a href="{{ route('news.index') }}">LATEST NEWS</a><a href="{{ route('about') }}">ABOUT</a><a href="{{ route('locale.switch',app()->getLocale()==='bg'?'en':'bg') }}">{{ strtoupper(app()->getLocale()) }}</a></div></div></div>
<header class="n2-header sticky-top">
    <div class="n2-container n2-header-inner">
        <a class="n2-brand" href="{{ route('home') }}"><span>N</span><div><b>{{ strtoupper($nexusAppearance['site_name']) }}</b><small>GAME COMMUNITY</small></div></a>
        <nav class="n2-desktop-nav">
            <a class="{{ request()->routeIs('home')?'active':'' }}" href="{{ route('home') }}">HOME</a>
            <a class="{{ request()->routeIs('servers.*')?'active':'' }}" href="{{ route('servers.index') }}">SERVERS</a>
            <a class="{{ request()->routeIs('news.*')?'active':'' }}" href="{{ route('news.index') }}">NEWS</a>
            <a class="{{ request()->routeIs('community.*')?'active':'' }}" href="{{ route('community.index') }}">COMMUNITY</a>
            <a class="{{ request()->routeIs('shop.*')?'active':'' }}" href="{{ route('shop.index') }}">SHOP</a>
            <a class="{{ request()->routeIs('bans.*')?'active':'' }}" href="{{ route('bans.index') }}">BANS</a>
        </nav>
        <div class="n2-account">@auth<a href="{{ route('profile.show',auth()->user()) }}">{{ auth()->user()->name }}</a>@if(auth()->user()->isAdmin())<a class="n2-admin-link" href="{{ route('admin.dashboard') }}">ADMIN</a>@endif @else<a href="{{ route('login') }}">SIGN IN</a>@endauth</div>
        <button class="n2-menu-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#nexusMobileNav" aria-controls="nexusMobileNav" aria-label="Open navigation"><span></span><span></span><span></span></button>
    </div>
</header>
<div class="offcanvas offcanvas-end n2-offcanvas" tabindex="-1" id="nexusMobileNav">
    <div class="offcanvas-header"><a class="n2-brand" href="{{ route('home') }}"><span>N</span><div><b>NEXUS</b><small>MAIN MENU</small></div></a><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
    <div class="offcanvas-body"><small class="n2-menu-label">NAVIGATION</small><nav>@foreach([['home','HOME',route('home')],['servers.*','SERVERS',route('servers.index')],['news.*','NEWS',route('news.index')],['community.*','COMMUNITY',route('community.index')],['shop.*','SHOP',route('shop.index')],['bans.*','BAN LIST',route('bans.index')],['about','ABOUT',route('about')]] as $item)<a class="{{ request()->routeIs($item[0])?'active':'' }}" href="{{ $item[2] }}"><span>{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</span><b>{{ $item[1] }}</b><i>→</i></a>@endforeach</nav><small class="n2-menu-label">ACCOUNT</small><div class="n2-mobile-account">@auth<a href="{{ route('profile.show',auth()->user()) }}">MY PROFILE</a>@if(auth()->user()->isAdmin())<a href="{{ route('admin.dashboard') }}">CONTROL CENTER</a>@endif<form method="POST" action="{{ route('logout') }}">@csrf<button>LOG OUT</button></form>@else<a href="{{ route('login') }}">SIGN IN</a>@endauth<a href="{{ route('locale.switch',app()->getLocale()==='bg'?'en':'bg') }}">LANGUAGE: {{ strtoupper(app()->getLocale()) }}</a></div></div>
</div>
<main class="n2-main">{{ $slot }}</main>
<footer class="n2-footer"><div class="n2-container"><a class="n2-brand" href="{{ route('home') }}"><span>N</span><div><b>NEXUS</b><small>GAME COMMUNITY</small></div></a><nav><a href="{{ route('servers.index') }}">Servers</a><a href="{{ route('news.index') }}">News</a><a href="{{ route('community.index') }}">Community</a><a href="{{ route('about') }}">About</a></nav><p>© {{ date('Y') }} NEXUS Engine</p></div></footer>
</body></html>
