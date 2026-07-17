<header class="topbar">
    <button class="icon-btn menu-trigger" type="button" data-menu-toggle aria-label="Отвори менюто">@svg('menu')</button>
    <div class="topbar-search">
        @svg('search')
        <input type="search" placeholder="Търси играч, SteamID или сървър..." aria-label="Търсене">
        <kbd>Ctrl K</kbd>
    </div>
    <div class="topbar-actions">
        <button class="balance-pill" type="button"><span>Баланс</span><strong>125.40 лв.</strong><i>+</i></button>
        <button class="icon-btn notification-btn" type="button" aria-label="Известия">@svg('bell')<span></span></button>
        <button class="profile-chip" type="button">
            <span class="avatar avatar-gradient">RS</span>
            <span class="profile-chip-copy"><strong>ROG_STRIX</strong><small>Administrator</small></span>
            @svg('chevron')
        </button>
    </div>
</header>
