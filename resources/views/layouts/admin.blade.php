<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="csrf-token" content="{{ csrf_token() }}"><title>{{ $title ?? $nexusAppearance['site_name'].' Control' }}</title><meta name="theme-color" content="{{ $nexusAppearance['accent'] }}">@vite(['resources/css/app.css','resources/js/app.js'])</head>
<body class="admin-body" style="--accent:{{ $nexusAppearance['accent'] }};--accent2:{{ $nexusAppearance['accent'] }}">
<aside class="sidebar">
    <a class="brand" href="{{ route('admin.dashboard') }}"><span class="brand-mark">✣</span><span><b>{{ $nexusAppearance['site_name'] }}</b><small>CONTROL CENTER</small></span></a>
    <div class="side-label">СЪДЪРЖАНИЕ</div>
    <nav>
        <a class="{{ request()->routeIs('admin.dashboard')?'active':'' }}" href="{{ route('admin.dashboard') }}">⌂ <span>Табло</span></a>
        <a class="{{ request()->routeIs('admin.news.*')?'active':'' }}" href="{{ route('admin.news.index') }}">▤ <span>Новини</span></a>
        <a class="{{ request()->routeIs('admin.servers.*')?'active':'' }}" href="{{ route('admin.servers.index') }}">◉ <span>Сървъри</span></a>
        <a class="{{ request()->routeIs('admin.users.*','admin.roles.*')?'active':'' }}" href="{{ route('admin.users.index') }}">♙ <span>Потребители</span></a>
        <a class="{{ request()->routeIs('admin.modules.*')?'active':'' }}" href="{{ route('admin.modules.index') }}">▣ <span>Модули</span></a>
    </nav>
    <div class="side-label">СИСТЕМА</div>
    <nav><a class="{{ request()->routeIs('admin.settings.*')?'active':'' }}" href="{{ route('admin.settings.edit') }}">⚙ <span>Настройки</span></a><a href="{{ route('home') }}">↗ <span>Към сайта</span></a></nav>
    <form method="POST" action="{{ route('logout') }}">@csrf<button>⇥ <span>Изход</span></button></form>
</aside>
<main class="admin-main"><header class="admin-top"><div><small>{{ $nexusAppearance['site_name'] }} / CONTROL</small><h1>{{ $heading ?? 'Контролен център' }}</h1></div><div class="admin-user"><span>{{ strtoupper(mb_substr(auth()->user()->name,0,1)) }}</span><div><b>{{ auth()->user()->name }}</b><small>{{ auth()->user()->role }}</small></div></div></header><div class="admin-content">@if(session('success'))<div class="flash">✓ {{ session('success') }}</div>@endif{{ $slot }}</div></main>
</body></html>
