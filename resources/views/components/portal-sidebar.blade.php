<aside class="portal-unified-sidebar">
    <section class="portal-widget member-widget">
        <header>MEMBER AREA</header>
        @auth
            <div class="member-welcome">
                @if(auth()->user()->avatar_url)<img src="{{ auth()->user()->avatar_url }}" alt="">@else<span>{{ mb_substr(auth()->user()->name, 0, 1) }}</span>@endif
                <div><small>LOGGED IN AS</small><b>{{ auth()->user()->name }}</b><a href="{{ route('profile.show', auth()->user()) }}">VIEW PROFILE →</a></div>
            </div>
        @else
            <p>Влез със Steam, за да използваш профила, магазина и community функциите.</p>
            <a class="portal-button" href="{{ route('auth.steam') }}">SIGN IN WITH STEAM</a>
            <a class="text-login" href="{{ route('login') }}">Admin login</a>
        @endauth
    </section>

    <section class="portal-widget">
        <header>SECTIONS</header>
        <nav class="quick-menu">
            <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"><i>01</i><span><b>Home</b><small>Network overview</small></span></a>
            <a class="{{ request()->routeIs('servers.*') ? 'active' : '' }}" href="{{ route('servers.index') }}"><i>02</i><span><b>Servers</b><small>Live game network</small></span></a>
            <a class="{{ request()->routeIs('community.*') ? 'active' : '' }}" href="{{ route('community.index') }}"><i>03</i><span><b>Community</b><small>Members & profiles</small></span></a>
            <a class="{{ request()->routeIs('shop.*') ? 'active' : '' }}" href="{{ route('shop.index') }}"><i>04</i><span><b>VIP Shop</b><small>Services & upgrades</small></span></a>
            <a class="{{ request()->routeIs('bans.*') ? 'active' : '' }}" href="{{ route('bans.index') }}"><i>05</i><span><b>Ban List</b><small>Security center</small></span></a>
        </nav>
    </section>

    <section class="portal-widget portal-network-state">
        <header>NETWORK STATUS</header>
        <div><i></i><span><b>SYSTEMS ONLINE</b><small>NEXUS services operational</small></span></div>
    </section>
</aside>
