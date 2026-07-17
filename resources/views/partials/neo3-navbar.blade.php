<div class="navbar row">
    <div class="navbar_menu_left">
        <a class="logo-text" href="{{ route('home') }}">
            <div class="site_logo_neo">
                <img class="logo" src="{{ asset('assets/img/nexus-mark.svg') }}" alt="NEXUS">
                <span class="nexus-wordmark"><b>NEXUS</b><small>GAME CMS</small></span>
            </div>
        </a>
        <div class="online">
            <div class="online__counter" id="counter">
                <div class="online__square-wrapper"><span class="online__square-figure"></span></div>
                <div class="online__count" id="servers_total">18</div>
            </div>
            <div class="online__wrapper" id="counterWrapper">
                <div class="online__item"><div class="online__item-server-name">PUBLIC:</div><span>28 / 32</span></div>
                <div class="online__item"><div class="online__item-server-name">RETAKES:</div><span>19 / 24</span></div>
                <div class="online__item"><div class="online__item-server-name">AWP:</div><span>14 / 20</span></div>
                <hr>
                <div class="online__item"><div class="online__item-server-name">Общо онлайн:</div><span>1 248</span></div>
            </div>
        </div>
        <button class="header_burger" type="button" aria-label="Мобилно меню"><span></span></button>
        <div class="nav_header_menu no_scroll">
            <ul class="header_list">
                <li><a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Начало</a></li>
                <li><a class="{{ request()->routeIs('leaderboard') ? 'active' : '' }}" href="{{ route('leaderboard') }}">Лидери</a></li>
                <li><a class="{{ request()->routeIs('punishments') ? 'active' : '' }}" href="{{ route('punishments') }}">Наказания</a></li>
                <li><a class="{{ request()->routeIs('skinchanger') ? 'active' : '' }}" href="{{ route('skinchanger') }}">Skinchanger</a></li>
                <li><a class="{{ request()->routeIs('tickets') ? 'active' : '' }}" href="{{ route('tickets') }}">Тикети</a></li>
                <li><a class="{{ request()->routeIs('store') ? 'active' : '' }}" href="{{ route('store') }}">Магазин</a></li>
                <li><a class="{{ request()->routeIs('rules') ? 'active' : '' }}" href="{{ route('rules') }}">Правила</a></li>
            </ul>
        </div>
    </div>
    <div class="navbar_usermenu">
        <div class="neo3-mobile-brand"><img src="{{ asset('assets/img/nexus-mark.svg') }}" alt=""><b>NEXUS</b></div>
        <div class="search_players" id="open_search">
            <div class="modal-searchcontent">
                <form action="{{ route('profile') }}" method="get">
                    <input class="search-input-block" type="text" placeholder="Намери играч" name="steam">
                    @svg('search')
                </form>
            </div>
        </div>
        <button class="pay_button" type="button">@svg('store')<span class="hide_balance_text">Зареди баланс</span></button>
        <button class="language button-icon" id="openLanguage" type="button">@svg('settings')</button>
        <div class="language__modal">
            <div class="language__modal-current"><span class="language__modal-title">Избран език</span><div class="language__modal-current-lang">🇧🇬 Български</div></div>
            <hr>
            <div class="language__modal-list"><span class="language__modal-title">Избери език</span><button class="language__modal-item width-100" type="button">🇬🇧 English</button></div>
        </div>
        <button type="button">@svg('play') Вход със Steam</button>
    </div>
</div>
