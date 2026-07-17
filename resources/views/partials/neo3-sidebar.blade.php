<aside class="sidebar">
    <nav class="sidebar__wrapper">
        <span class="sidebar__header">
            <span class="sidebar__header-text">Навигация</span>
            <button class="sidebar__toggle" type="button" aria-label="Свиване на навигацията">
                @svg('chevron')
                <span class="sidebar__slider"></span>
            </button>
        </span>
        <ul class="sidebar__list">
            <li><a class="sidebal__item {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">@svg('home')<span class="sidebar__item-text">Начало</span></a></li>
            <li><a class="sidebal__item {{ request()->routeIs('leaderboard') ? 'active' : '' }}" href="{{ route('leaderboard') }}">@svg('trophy')<span class="sidebar__item-text">Лидерборд</span></a></li>
            <li><a class="sidebal__item {{ request()->routeIs('punishments') ? 'active' : '' }}" href="{{ route('punishments') }}">@svg('gavel')<span class="sidebar__item-text">Наказания</span></a></li>
            <li><a class="sidebal__item {{ request()->routeIs('faq') ? 'active' : '' }}" href="{{ route('faq') }}">@svg('help')<span class="sidebar__item-text">FAQ</span></a></li>
            <li class="{{ request()->routeIs('store','skinchanger','tickets','profile','rules') ? 'is-open' : '' }}">
                <button class="sidebal__item sidebar__submenu {{ request()->routeIs('store','skinchanger','tickets','profile','rules') ? 'active' : '' }}" type="button" aria-expanded="{{ request()->routeIs('store','skinchanger','tickets','profile','rules') ? 'true' : 'false' }}">
                    @svg('store')<span class="sidebar__item-text">Услуги</span>@svg('chevron')
                </button>
                <ul class="sidebar__sublist">
                    <li><a class="sidebar__subitem {{ request()->routeIs('skinchanger') ? 'active' : '' }}" href="{{ route('skinchanger') }}">@svg('sparkles') Skinchanger</a></li>
                    <li><a class="sidebar__subitem {{ request()->routeIs('tickets') ? 'active' : '' }}" href="{{ route('tickets') }}">@svg('ticket') Тикети</a></li>
                    <li><a class="sidebar__subitem {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">@svg('search') Търси играч</a></li>
                    <li><a class="sidebar__subitem {{ request()->routeIs('store') ? 'active' : '' }}" href="{{ route('store') }}">@svg('store') Магазин</a></li>
                    <li><a class="sidebar__subitem {{ request()->routeIs('rules') ? 'active' : '' }}" href="{{ route('rules') }}">@svg('book') Правила</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
