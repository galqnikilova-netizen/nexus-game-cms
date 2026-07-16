<x-layouts.app title="Сървъри · NEXUS">
    <section class="portal-subhead"><div class="portal-shell"><div class="portal-breadcrumb"><a href="{{ route('home') }}">HOME</a><span>/</span><b>SERVERS</b></div><small>LIVE NETWORK</small><h1>GAME SERVERS</h1><p>Live status, карти и играчи от цялата NEXUS мрежа.</p></div></section>
    <div class="portal-shell portal-page-grid">
        <x-portal-sidebar />
        <main class="portal-page-main">
            <header class="portal-heading lgsl-heading"><div><small>LGSL LIVE MONITOR</small><h2>ACTIVE NETWORK</h2></div><div class="server-view-switch"><button class="active" data-server-view="cards">CARDS</button><button data-server-view="table">TABLE</button></div></header>
            <div class="server-filter-strip"><b>ALL SERVERS <span>{{ $servers->total() }}</span></b><span>COUNTER-STRIKE 2</span><span>CS 1.6</span><span>MINECRAFT</span><i>QUERY ENGINE: OPERATIONAL</i></div>
            <div class="lgsl-browser" data-server-browser data-view="cards">
            <div class="lgsl-server-cards">
                @forelse($servers as $server)
                    <article class="lgsl-card">
                        <div class="lgsl-map" style="--map-art:url('{{ $server->mapArtwork() }}')"><span>{{ strtoupper($server->current_map ?: 'NO MAP') }}</span><b class="directory-status {{ $server->status }}">{{ strtoupper($server->status) }}</b></div>
                        <div class="lgsl-card-body"><small>{{ strtoupper($server->game) }} SERVER</small><h3>{{ $server->name }}</h3><code>{{ $server->host }}:{{ $server->port }}</code><div class="lgsl-stats"><span><small>PLAYERS</small><b>{{ $server->players_online }} / {{ $server->players_max }}</b></span><span><small>PING</small><b>{{ $server->latency_ms ?? '—' }} ms</b></span><span><small>UPDATED</small><b>{{ $server->last_query_at?->diffForHumans(short:true) ?? '—' }}</b></span></div><em><i style="width:{{ $server->players_max ? min(100, ($server->players_online / $server->players_max) * 100) : 0 }}%"></i></em></div>
                        <footer><a href="steam://connect/{{ $server->host }}:{{ $server->port }}">CONNECT</a><button type="button" data-copy-server="{{ $server->host }}:{{ $server->port }}">COPY IP</button></footer>
                    </article>
                @empty
                    <div class="portal-empty"><b>NO SERVERS CONFIGURED</b><p>Добави първия сървър от контролния панел.</p></div>
                @endforelse
            </div>
            <div class="server-directory">
                <div class="server-directory-head"><span>GAME</span><span>SERVER / ADDRESS</span><span>CURRENT MAP</span><span>PLAYERS</span><span>STATUS</span></div>
                @forelse($servers as $server)
                    <article><span class="directory-map-thumb" style="--map-art:url('{{ $server->mapArtwork() }}')"></span><div><b>{{ $server->name }}</b><code>{{ $server->host }}:{{ $server->port }}</code></div><div><b>{{ $server->current_map ?? 'Awaiting query' }}</b><small>{{ strtoupper($server->game) }}</small></div><div class="directory-players"><b>{{ $server->players_online }}<small>/{{ $server->players_max }}</small></b><em><i style="width:{{ $server->players_max ? min(100, ($server->players_online / $server->players_max) * 100) : 0 }}%"></i></em></div><span class="directory-status {{ $server->status }}">{{ strtoupper($server->status) }}</span></article>
                @empty
                    <div class="portal-empty"><b>NO SERVERS CONFIGURED</b><p>Добави първия CS2, CS 1.6 или Minecraft сървър от контролния панел.</p>@auth @if(auth()->user()->isAdmin())<a href="{{ route('admin.servers.create') }}">ADD SERVER →</a>@endif @else<a href="{{ route('login') }}">ADMIN LOGIN →</a>@endauth</div>
                @endforelse
            </div></div>
            <div class="server-pages">{{ $servers->links() }}</div>
        </main>
    </div>
</x-layouts.app>
