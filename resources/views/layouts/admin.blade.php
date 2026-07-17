<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'NEXUS Control' }}</title>@vite(['resources/css/app.css','resources/js/app.js'])
</head>
@php
    $accentHex = ltrim($nexusAppearance['accent'], '#');
    $accentRgb = strlen($accentHex)===6 ? hexdec(substr($accentHex,0,2)).','.hexdec(substr($accentHex,2,2)).','.hexdec(substr($accentHex,4,2)) : '124,134,255';
    $links=[
    ['admin.dashboard','dashboard','Dashboard',route('admin.dashboard')],
    ['admin.servers.*','servers','Servers',route('admin.servers.index')],
    ['admin.news.*','news','News',route('admin.news.index')],
    ['admin.products.*','shop','Store',route('admin.products.index')],
    ['admin.users.*','users','Users',route('admin.users.index')],
    ['admin.roles.*','roles','Roles',route('admin.roles.index')],
    ['admin.modules.*','modules','Modules',route('admin.modules.index')],
    ['admin.settings.*','settings','Settings',route('admin.settings.edit')],
    ];
@endphp
<body style="--nx-accent:{{ $nexusAppearance['accent'] }};--accent:{{ $nexusAppearance['accent'] }};--nx-accent-rgb:{{ $accentRgb }}">
<div class="nx-admin-shell">
    <aside class="nx-admin-side">
        <a class="nx-admin-brand" href="{{ route('admin.dashboard') }}"><span class="nx-logo-mark">N</span><span><strong>NEXUS CONTROL</strong><small>Network administration</small></span></a>
        <nav class="nx-admin-nav"><span class="nx-admin-nav-label">Workspace</span>@foreach($links as $item)<a class="nx-admin-link {{ request()->routeIs($item[0])?'is-active':'' }}" href="{{ $item[3] }}"><x-nx-icon :name="$item[1]"/>{{ $item[2] }}</a>@endforeach</nav>
        <div class="mt-auto border-t border-white/[.06] p-3">
            <a class="nx-admin-link" href="{{ route('home') }}"><x-nx-icon name="external"/>View website</a>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="nx-admin-link w-full"><x-nx-icon name="logout"/>Log out</button></form>
        </div>
    </aside>
    <main class="nx-admin-main">
        <header class="nx-admin-top">
            <button class="nx-mobile-icon md:hidden" type="button" data-admin-sheet-open><x-nx-icon name="more"/></button>
            <div><h1>{{ $heading ?? 'Control Center' }}</h1><p>Manage the network, community and platform services</p></div>
            <div class="ml-auto flex items-center gap-2"><a class="nx-top-action" href="{{ route('locale.switch',app()->getLocale()==='bg'?'en':'bg') }}">{{ strtoupper(app()->getLocale()) }}</a><a class="nx-top-action" href="{{ route('profile.show',auth()->user()) }}">@if(auth()->user()->avatar_url)<img class="nx-avatar" src="{{ auth()->user()->avatar_url }}" alt="">@else<span class="nx-avatar grid place-items-center font-black">{{ mb_substr(auth()->user()->name,0,1) }}</span>@endif<span class="hidden sm:inline">{{ auth()->user()->name }}</span></a></div>
        </header>
        <div class="nx-admin-body">@if(session('success'))<div class="nx-card mb-4 border-emerald-500/20 p-4 text-xs text-emerald-300">✓ {{ session('success') }}</div>@endif{{ $slot }}</div>
    </main>
    <div class="nx-mobile-sheet" id="nx-admin-menu" aria-hidden="true"><button class="nx-sheet-backdrop" data-admin-sheet-close></button><div class="nx-sheet-panel"><div class="nx-sheet-grid">@foreach($links as $item)<a class="nx-sheet-link" href="{{ $item[3] }}"><x-nx-icon :name="$item[1]"/>{{ $item[2] }}</a>@endforeach<a class="nx-sheet-link" href="{{ route('home') }}"><x-nx-icon name="external"/>Website</a></div></div></div>
</div>
</body>
</html>
