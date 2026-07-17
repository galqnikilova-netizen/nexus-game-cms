<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#111111">
    <title>@yield('title', 'NEXUS Game CMS')</title>
    <meta name="description" content="NEXUS Game CMS — gaming community platform.">
    <link rel="icon" href="{{ asset('assets/img/nexus-mark.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/css/neo3-exact-core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/neo3-exact-home.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/neo3-nexus-adapter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/neo3-pages.css') }}">
    @stack('styles')
</head>
<body class="sidebar-collapse neo3-nexus">
    @include('partials.neo3-sidebar')
    <div class="neo3-mobile-backdrop" data-neo3-backdrop></div>
    <div class="global-container">
        <div class="container-fluid">
            @include('partials.neo3-navbar')
            @yield('content')
        </div>
    </div>
    @include('partials.neo3-footer')
    <div class="neo3-toast">IP адресът е копиран</div>
    <script src="{{ asset('assets/js/neo3-exact.js') }}" defer></script>
    <script src="{{ asset('assets/js/neo3-pages.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
