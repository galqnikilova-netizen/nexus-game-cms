<aside class="sidebar" data-sidebar>
    <div class="sidebar-brand">
        <a href="{{ route('home') }}" class="brand-lockup">
            <img src="{{ asset('assets/img/nexus-mark.svg') }}" alt="NEXUS">
            <span><strong>NEXUS</strong><small>GAME CMS</small></span>
        </a>
        <button class="icon-btn sidebar-close" type="button" data-menu-toggle aria-label="Затвори менюто">@svg('x')</button>
    </div>
    <nav class="sidebar-nav">
        <span class="nav-caption">Основно</span>
        <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'is-active' : '' }}">@svg('home')<span>Начало</span></a>
        <a href="{{ route('leaderboard') }}" class="nav-item {{ request()->routeIs('leaderboard') ? 'is-active' : '' }}">@svg('trophy')<span>Лидерборд</span><em>LIVE</em></a>
        <a href="{{ route('punishments') }}" class="nav-item {{ request()->routeIs('punishments') ? 'is-active' : '' }}">@svg('gavel')<span>Наказания</span></a>
        <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'is-active' : '' }}">@svg('search')<span>Търси играч</span></a>

        <span class="nav-caption">Услуги</span>
        <a href="{{ route('store') }}" class="nav-item {{ request()->routeIs('store') ? 'is-active' : '' }}">@svg('store')<span>Магазин</span></a>
        <a href="{{ route('skinchanger') }}" class="nav-item {{ request()->routeIs('skinchanger') ? 'is-active' : '' }}">@svg('sparkles')<span>Skinchanger</span><em class="violet">NEW</em></a>
        <a href="{{ route('tickets') }}" class="nav-item {{ request()->routeIs('tickets') ? 'is-active' : '' }}">@svg('ticket')<span>Тикети</span><b>3</b></a>

        <span class="nav-caption">Информация</span>
        <a href="{{ route('rules') }}" class="nav-item {{ request()->routeIs('rules') ? 'is-active' : '' }}">@svg('book')<span>Правила</span></a>
        <a href="{{ route('faq') }}" class="nav-item {{ request()->routeIs('faq') ? 'is-active' : '' }}">@svg('help')<span>FAQ</span></a>
    </nav>
    <div class="sidebar-promo">
        <span class="eyebrow">NEXUS PASS</span>
        <strong>Отключи целия проект</strong>
        <p>VIP, coins, персонални skins и приоритетна поддръжка.</p>
        <a class="button button-primary button-sm" href="{{ route('store') }}">Разгледай</a>
    </div>
    <div class="sidebar-foot"><span class="status-dot"></span><span><strong>18 сървъра онлайн</strong><small>1 248 играчи</small></span></div>
</aside>
<div class="sidebar-backdrop" data-menu-toggle></div>
