<footer class="footer_fluid">
    <div class="tabbar_mobile">
        <a class="{{ request()->routeIs('home') ? 'tabbar_active' : '' }}" href="{{ route('home') }}">@svg('home')</a>
        <a class="{{ request()->routeIs('leaderboard') ? 'tabbar_active' : '' }}" href="{{ route('leaderboard') }}">@svg('trophy')</a>
        <a class="{{ request()->routeIs('store') ? 'tabbar_active' : '' }}" href="{{ route('store') }}">@svg('store')</a>
    </div>
    <div class="footer_global">
        <div class="footer-top">
            <div class="left_footer"><a href="{{ route('home') }}"><div class="footer_sitename">NEXUS</div></a></div>
            <div class="footer_links"><ul><li><a href="{{ route('rules') }}">Правила</a></li><li><a href="{{ route('faq') }}">FAQ</a></li><li><a href="{{ route('tickets') }}">Поддръжка</a></li></ul></div>
            <div class="social_buttons"><a class="social_button" href="#">@svg('users')</a><a class="social_button" href="#">@svg('play')</a><a class="social_button" href="#">@svg('ticket')</a></div>
        </div>
        <hr>
        <div class="footer-bottom"><p class="footer-description neo3-footer-copy">© {{ date('Y') }} NEXUS Game CMS. Gaming platform for communities.</p></div>
    </div>
</footer>
