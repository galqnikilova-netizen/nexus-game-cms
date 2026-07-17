<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? $nexusAppearance['site_name'] }}</title><meta name="description" content="{{ $nexusAppearance['site_tagline'] }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
@php
    $accent=ltrim($nexusAppearance['accent'],'#');
    $rgb=strlen($accent)===6?hexdec(substr($accent,0,2)).','.hexdec(substr($accent,2,2)).','.hexdec(substr($accent,4,2)):'112,104,232';
    $nav=[
        ['home','home',route('home'),__('ui.nav.home')],
        ['leaderboard.*','leaderboard',route('leaderboard.index'),app()->getLocale()==='bg'?'Класация':'Leaders'],
        ['servers.*','servers',route('servers.index'),__('ui.nav.servers')],
        ['shop.*','shop',route('shop.index'),__('ui.nav.shop')],
        ['bans.*','bans',route('bans.index'),__('ui.nav.bans')],
        ['community.*','community',route('community.index'),app()->getLocale()==='bg'?'Общност':'Community'],
    ];
    $onlineCount=\App\Models\GameServer::query()->where('is_visible',true)->sum('players_online');
@endphp
<body style="--n3-accent:{{ $nexusAppearance['accent'] }};--n3-rgb:{{ $rgb }}">
<div class="n3-app">
    <aside class="n3-rail">
        <a class="n3-logo" href="{{ route('home') }}"><span>N</span></a>
        <nav class="n3-nav">
            @foreach($nav as $item)<a class="n3-nav-link {{ request()->routeIs($item[0])?'active':'' }}" href="{{ $item[2] }}"><x-nx-icon :name="$item[1]"/><span class="n3-tooltip">{{ $item[3] }}</span></a>@endforeach
        </nav>
        <nav class="n3-nav bottom">
            @auth<a class="n3-nav-link" href="{{ route('profile.show',auth()->user()) }}"><x-nx-icon name="user"/><span class="n3-tooltip">Profile</span></a>@else<a class="n3-nav-link" href="{{ route('login') }}"><x-nx-icon name="user"/><span class="n3-tooltip">Sign in</span></a>@endauth
        </nav>
    </aside>
    <header class="n3-top"><div class="n3-top-inner">
        <a class="n3-brand" href="{{ route('home') }}"><span><b>{{ strtoupper($nexusAppearance['site_name']) }}</b><small>GAME COMMUNITY NETWORK</small></span></a>
        <span class="n3-online"><i></i>{{ $onlineCount }} {{ app()->getLocale()==='bg'?'играчи онлайн':'players online' }}</span>
        <label class="n3-search"><x-nx-icon name="search"/><input type="search" placeholder="{{ app()->getLocale()==='bg'?'Намери играч или сървър':'Find player or server' }}"></label>
        <a class="n3-action" href="{{ route('locale.switch',app()->getLocale()==='bg'?'en':'bg') }}">{{ strtoupper(app()->getLocale()) }}</a>
        @auth
            @if(auth()->user()->isAdmin())<a class="n3-action primary" href="{{ route('admin.dashboard') }}"><x-nx-icon name="dashboard"/> Control</a>@endif
            <a class="n3-action" href="{{ route('profile.show',auth()->user()) }}">@if(auth()->user()->avatar_url)<img src="{{ auth()->user()->avatar_url }}" alt="">@endif{{ auth()->user()->name }}</a>
        @else<a class="n3-action primary" href="{{ route('login') }}"><x-nx-icon name="user"/>{{ app()->getLocale()==='bg'?'Вход':'Sign in' }}</a>@endauth
    </div></header>
    <header class="n3-mobile-top">
        <a class="n3-logo" href="{{ route('home') }}"><span>N</span></a><b class="n3-mobile-brand">NEXUS</b>
        <div class="n3-mobile-actions"><a class="n3-mobile-action" href="{{ route('locale.switch',app()->getLocale()==='bg'?'en':'bg') }}">{{ strtoupper(app()->getLocale()) }}</a>@auth<a class="n3-mobile-action" href="{{ route('profile.show',auth()->user()) }}"><x-nx-icon name="user"/></a>@else<a class="n3-mobile-action" href="{{ route('login') }}"><x-nx-icon name="user"/></a>@endauth</div>
    </header>
    <main class="n3-main">{{ $slot }}</main>
    <nav class="n3-mobile-nav">
        @foreach(array_slice($nav,0,4) as $item)<a class="{{ request()->routeIs($item[0])?'active':'' }}" href="{{ $item[2] }}"><x-nx-icon :name="$item[1]"/><span>{{ $item[3] }}</span></a>@endforeach
        <button type="button" data-n3-menu-open><x-nx-icon name="more"/><span>{{ app()->getLocale()==='bg'?'Още':'More' }}</span></button>
    </nav>
    <div class="n3-mobile-drawer" id="n3-menu" aria-hidden="true"><button class="n3-drawer-backdrop" data-n3-menu-close></button><div class="n3-drawer-panel"><div class="n3-drawer-handle"></div><div class="n3-drawer-grid">
        @foreach(array_slice($nav,4) as $item)<a class="n3-drawer-link" href="{{ $item[2] }}"><x-nx-icon :name="$item[1]"/>{{ $item[3] }}</a>@endforeach
        <a class="n3-drawer-link" href="{{ route('news.index') }}"><x-nx-icon name="news"/>News</a><a class="n3-drawer-link" href="{{ route('about') }}"><x-nx-icon name="community"/>About</a>
        @auth @if(auth()->user()->isAdmin())<a class="n3-drawer-link" href="{{ route('admin.dashboard') }}"><x-nx-icon name="dashboard"/>Control</a>@endif @endauth
    </div></div></div>
</div>
</body></html>
