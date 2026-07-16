<x-layouts.app title="{{ $nexusAppearance['site_name'] }}">
    <section class="portal-subhead portal-home-subhead">
        <div class="portal-shell"><div class="portal-breadcrumb"><b>HOME</b></div><small>NEXUS NETWORK</small><h1>{{ __('ui.hero.title') }} {{ __('ui.hero.accent') }}</h1><p>{{ __('ui.hero.copy') }}</p></div>
    </section>

    <div class="portal-shell portal-page-grid">
        <x-portal-sidebar />
        <main class="portal-page-main portal-home-content">
            <article class="portal-slider">
                <div class="slide-overlay"><span>FEATURED / NEXUS NETWORK</span><h1>PLAY. COMPETE.<br>BELONG.</h1><p>Собствена gaming общност със live сървъри, Steam профили, роли, наказания и услуги.</p><a href="{{ route('servers.index') }}">ENTER THE SERVERS <b>→</b></a></div>
                <div class="slide-tabs"><b>01</b><span></span><i>03</i></div>
            </article>

            <header class="portal-heading"><div><small>LATEST UPDATES</small><h2>COMMUNITY NEWS</h2></div><a href="{{ route('community.index') }}">VIEW ALL</a></header>
            <article class="portal-news featured"><div class="news-thumb"><b>NX</b><span>UPDATE</span></div><div><small>17 JUL 2026 · PLATFORM</small><h3>NEXUS community platform is now online</h3><p>Нова собствена основа за gaming общности — сървъри, Steam профили, роли, наказания и магазин в една система.</p><footer><a href="{{ route('community.index') }}">READ MORE →</a><span>0 COMMENTS</span></footer></div></article>

            <header class="portal-heading"><div><small>LIVE STATUS</small><h2>GAME SERVERS</h2></div><a href="{{ route('servers.index') }}">VIEW ALL SERVERS</a></header>
            <section class="portal-home-servers">
                @forelse($servers as $server)
                    <a class="portal-server" href="{{ route('servers.index') }}"><span>{{ strtoupper(substr($server->game, 0, 2)) }}</span><div><b>{{ $server->name }}</b><small>{{ $server->current_map ?? $server->host.':'.$server->port }}</small><em><i style="width:{{ $server->players_max ? min(100, ($server->players_online / $server->players_max) * 100) : 0 }}%"></i></em></div><strong>{{ $server->players_online }}<small>/{{ $server->players_max }}</small></strong></a>
                @empty
                    <div class="portal-server-empty">No servers configured yet.</div>
                @endforelse
            </section>
        </main>
    </div>
</x-layouts.app>
