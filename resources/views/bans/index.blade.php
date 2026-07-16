<x-layouts.app title="Ban List · NEXUS">
    <section class="portal-subhead">
        <div class="portal-shell">
            <div class="portal-breadcrumb"><a href="{{ route('home') }}">HOME</a><span>/</span><b>BAN LIST</b></div>
            <small>SECURITY CENTER</small><h1>PUBLIC BAN LIST</h1>
            <p>Прозрачен регистър на наказанията в NEXUS server network.</p>
        </div>
    </section>

    <section class="portal-shell portal-page-grid">
        <x-portal-sidebar />
        <main class="portal-page-main">
        <div class="ban-summary">
            <article><small>TOTAL RECORDS</small><b>{{ number_format($stats['total']) }}</b><span>Всички наказания</span></article>
            <article><small>ACTIVE BANS</small><b>{{ number_format($stats['active']) }}</b><span>Активни в момента</span></article>
            <article><small>PERMANENT</small><b>{{ number_format($stats['permanent']) }}</b><span>Без краен срок</span></article>
            <aside><i></i><div><small>SYSTEM STATUS</small><b>{{ $enabled ? 'CSBANS ONLINE' : 'AWAITING CONNECTION' }}</b></div></aside>
        </div>

        <div class="ban-panel">
            <header>
                <div><small>SECURITY DATABASE</small><h2>BAN RECORDS</h2></div>
                <form method="GET" action="{{ route('bans.index') }}"><input name="q" value="{{ $search }}" placeholder="Player, SteamID или IP"><button>SEARCH</button></form>
            </header>
            @unless($enabled)
                <div class="ban-setup-state"><span>!</span><div><b>CSBans връзката не е конфигурирана</b><p>Добави CSBANS_DB_* настройките в production `.env`, за да активираш публичния регистър.</p></div></div>
            @else
                <div class="ban-table">
                    <div class="ban-table-head"><span>STATUS</span><span>PLAYER</span><span>REASON / SERVER</span><span>ADMIN / DATE</span><span>DURATION</span></div>
                    @forelse($bans as $ban)
                        <article>
                            <div><b class="ban-badge {{ $ban->is_active ? 'active' : 'expired' }}">{{ $ban->is_active ? 'ACTIVE' : 'EXPIRED' }}</b></div>
                            <div class="ban-player"><b>{{ $ban->player_nick ?: 'Unknown player' }}</b><code>{{ $ban->player_id ?: $ban->player_ip }}</code></div>
                            <div><b>{{ $ban->safe_reason ?: 'Не е посочена причина' }}</b><small>{{ $ban->server_name ?: 'Unknown server' }}</small></div>
                            <div><b>{{ $ban->admin_nick ?: 'Console' }}</b><small>{{ $ban->created_at->format('d.m.Y · H:i') }}</small></div>
                            <div><b>{{ $ban->is_permanent ? 'PERMANENT' : ($ban->expires_at?->diffForHumans() ?? 'EXPIRED') }}</b></div>
                        </article>
                    @empty
                        <div class="ban-no-results"><b>Няма намерени наказания</b><span>Промени търсенето или се върни по-късно.</span></div>
                    @endforelse
                </div>
                <div class="ban-pagination">{{ $bans->withQueryString()->links() }}</div>
            @endunless
        </div>
        </main>
    </section>
</x-layouts.app>
