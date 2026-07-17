<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b0b0e">
    <title>@yield('title', 'NEXUS Game CMS')</title>
    <meta name="description" content="NEXUS Game CMS — модерна система за gaming общности.">
    <link rel="icon" href="{{ asset('assets/img/nexus-mark.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/css/nexus.css') }}">
</head>
<body>
<div class="app-shell" data-shell>
    @include('partials.sidebar')
    <div class="app-stage">
        @include('partials.topbar')
        <main class="page-shell">
            @yield('content')
        </main>
        @include('partials.footer')
    </div>
</div>
<div class="mobile-dock" aria-label="Мобилна навигация">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}">@svg('home')<span>Начало</span></a>
    <a href="{{ route('leaderboard') }}" class="{{ request()->routeIs('leaderboard') ? 'is-active' : '' }}">@svg('trophy')<span>Лидери</span></a>
    <a href="{{ route('store') }}" class="{{ request()->routeIs('store') ? 'is-active' : '' }}">@svg('store')<span>Магазин</span></a>
    <button type="button" data-menu-toggle>@svg('menu')<span>Меню</span></button>
</div>
<div class="toast" data-toast><span class="toast-dot"></span><span data-toast-text>Копирано успешно</span></div>
<script src="{{ asset('assets/js/nexus.js') }}" defer></script>
</body>
</html>
