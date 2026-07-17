<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? $nexusAppearance['site_name'] }}</title>
    <meta name="description" content="{{ $nexusAppearance['site_tagline'] }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
@php
    $accentHex = ltrim($nexusAppearance['accent'], '#');
    $accentRgb = strlen($accentHex)===6 ? hexdec(substr($accentHex,0,2)).','.hexdec(substr($accentHex,2,2)).','.hexdec(substr($accentHex,4,2)) : '124,134,255';
    $nav = [
        ['home','home',route('home'),__('ui.nav.home')],
        ['servers.*','servers',route('servers.index'),__('ui.nav.servers')],
        ['community.*','community',route('community.index'),__('ui.nav.community')],
        ['shop.*','shop',route('shop.index'),__('ui.nav.shop')],
        ['bans.*','bans',route('bans.index'),__('ui.nav.bans')],
    ];
    $onlineCount = \App\Models\GameServer::query()->where('is_visible',true)->sum('players_online');
@endphp
<body style="--nx-accent:{{ $nexusAppearance['accent'] }};--accent:{{ $nexusAppearance['accent'] }};--nx-accent-rgb:{{ $accentRgb }}">
<div class="nx-app">
    <aside class="nx-rail" aria-label="Main navigation">
        <a class="nx-rail-logo" href="{{ route('home') }}" aria-label="NEXUS home"><span class="nx-logo-mark">N</span></a>
        <nav class="nx-rail-nav">
            @foreach($nav as $item)
                <a class="nx-rail-link {{ request()->routeIs($item[0]) ? 'is-active' : '' }}" href="{{ $item[2] }}" aria-label="{{ $item[3] }}">
                    <x-nx-icon :name="$item[1]"/><span class="nx-tip">{{ $item[3] }}</span>
                </a>
            @endforeach
            <a class="nx-rail-link {{ request()->routeIs('news.*') ? 'is-active' : '' }}" href="{{ route('news.index') }}" aria-label="News"><x-nx-icon name="news"/><span class="nx-tip">News</span></a>
        </nav>
        <div class="nx-rail-bottom">
            @auth
                <a class="nx-rail-link" href="{{ route('profile.show',auth()->user()) }}" aria-label="Profile"><x-nx-icon name="user"/><span class="nx-tip">Profile</span></a>
            @else
                <a class="nx-rail-link" href="{{ route('login') }}" aria-label="Sign in"><x-nx-icon name="user"/><span class="nx-tip">Sign in</span></a>
            @endauth
        </div>
    </aside>

    <header class="nx-topbar">
        <div class="nx-topbar-inner">
            <a class="nx-brand" href="{{ route('home') }}"><span><strong>{{ strtoupper($nexusAppearance['site_name']) }}</strong><small>GAME COMMUNITY NETWORK</small></span></a>
            <span class="nx-live-pill"><i class="nx-live-dot"></i>{{ $onlineCount }} {{ app()->getLocale()==='bg'?'играчи онлайн':'players online' }}</span>
            <label class="nx-global-search"><x-nx-icon name="search"/><input type="search" placeholder="{{ app()->getLocale()==='bg'?'Намери играч или сървър':'Find player or server' }}"></label>
            <a class="nx-top-action" href="{{ route('locale.switch',app()->getLocale()==='bg'?'en':'bg') }}">{{ strtoupper(app()->getLocale()) }}</a>
            @auth
                @if(auth()->user()->isAdmin())<a class="nx-top-action is-primary" href="{{ route('admin.dashboard') }}"><x-nx-icon name="dashboard"/> Control</a>@endif
                <a class="nx-top-action" href="{{ route('profile.show',auth()->user()) }}">@if(auth()->user()->avatar_url)<img class="nx-avatar" src="{{ auth()->user()->avatar_url }}" alt="">@endif {{ auth()->user()->name }}</a>
            @else
                <a class="nx-top-action is-primary" href="{{ route('login') }}"><x-nx-icon name="user"/> {{ app()->getLocale()==='bg'?'Вход':'Sign in' }}</a>
            @endauth
        </div>
    </header>

    <header class="nx-mobile-top">
        <a href="{{ route('home') }}" class="nx-logo-mark">N</a><span class="nx-mobile-brand">NEXUS</span>
        <div class="nx-mobile-top-actions">
            <a class="nx-mobile-icon" href="{{ route('locale.switch',app()->getLocale()==='bg'?'en':'bg') }}">{{ strtoupper(app()->getLocale()) }}</a>
            @auth<a class="nx-mobile-icon" href="{{ route('profile.show',auth()->user()) }}"><x-nx-icon name="user"/></a>@else<a class="nx-mobile-icon" href="{{ route('login') }}"><x-nx-icon name="user"/></a>@endauth
        </div>
    </header>

    <main class="nx-page">{{ $slot }}</main>

    <nav class="nx-mobile-nav" aria-label="Mobile navigation">
        @foreach(array_slice($nav,0,4) as $item)<a class="{{ request()->routeIs($item[0])?'is-active':'' }}" href="{{ $item[2] }}"><x-nx-icon :name="$item[1]"/><span>{{ $item[3] }}</span></a>@endforeach
        <button type="button" data-mobile-sheet-open><x-nx-icon name="more"/><span>{{ app()->getLocale()==='bg'?'Още':'More' }}</span></button>
    </nav>
    <div class="nx-mobile-sheet" id="nx-mobile-menu" aria-hidden="true">
        <button class="nx-sheet-backdrop" data-mobile-sheet-close aria-label="Close"></button>
        <div class="nx-sheet-panel"><div class="nx-sheet-grid">
            <a class="nx-sheet-link" href="{{ route('bans.index') }}"><x-nx-icon name="bans"/>Ban list</a>
            <a class="nx-sheet-link" href="{{ route('news.index') }}"><x-nx-icon name="news"/>News</a>
            <a class="nx-sheet-link" href="{{ route('about') }}"><x-nx-icon name="community"/>About</a>
            @auth
                <a class="nx-sheet-link" href="{{ route('profile.show',auth()->user()) }}"><x-nx-icon name="user"/>Profile</a>
                @if(auth()->user()->isAdmin())<a class="nx-sheet-link" href="{{ route('admin.dashboard') }}"><x-nx-icon name="dashboard"/>Control</a>@endif
            @else<a class="nx-sheet-link" href="{{ route('login') }}"><x-nx-icon name="user"/>Sign in</a>@endauth
        </div></div>
    </div>
</div>
</body>
</html>
