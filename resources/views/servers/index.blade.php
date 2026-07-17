<x-layouts.app title="{{ app()->getLocale()==='bg'?'Сървъри':'Servers' }} · NEXUS">
@php($online = $servers->getCollection()->where('status','online')->count())
<div class="nx-page-pad">
    <div class="nx-shell">
        <div class="nx-section-head"><div><span class="nx-kicker">Server browser</span><h2>{{ app()->getLocale()==='bg'?'Игрови сървъри':'Game servers' }}</h2></div><span class="nx-live-pill"><i class="nx-live-dot"></i>{{ $online }} {{ app()->getLocale()==='bg'?'активни':'online' }}</span></div>
        <div class="nx-content-grid">
            <aside class="nx-card nx-filter-panel">
                <h3 class="nx-filter-title">{{ app()->getLocale()==='bg'?'Филтри':'Filters' }}</h3>
                <label class="nx-filter-label">{{ app()->getLocale()==='bg'?'Търсене':'Search' }}</label><input class="nx-input" type="search" data-server-search placeholder="{{ app()->getLocale()==='bg'?'Име, карта или IP':'Name, map or IP' }}">
                <span class="nx-filter-label">{{ app()->getLocale()==='bg'?'Статус':'Status' }}</span><div class="nx-filter-options"><button class="nx-filter-option is-active" data-server-filter="all">{{ app()->getLocale()==='bg'?'Всички':'All' }}<small>{{ $servers->total() }}</small></button><button class="nx-filter-option" data-server-filter="online">Online<small>{{ $online }}</small></button><button class="nx-filter-option" data-server-filter="offline">Offline<small>{{ $servers->getCollection()->where('status','!=','online')->count() }}</small></button></div>
                <span class="nx-filter-label">{{ app()->getLocale()==='bg'?'Игри':'Games' }}</span><div class="nx-filter-options">@foreach($servers->getCollection()->groupBy('game') as $game=>$items)<button class="nx-filter-option" data-server-game="{{ $game }}">{{ strtoupper($game) }}<small>{{ $items->count() }}</small></button>@endforeach</div>
                <a class="nx-button mt-5 w-full" href="steam://connect/{{ optional($servers->firstWhere('status','online'))->host }}:{{ optional($servers->firstWhere('status','online'))->port }}">{{ app()->getLocale()==='bg'?'Бърза игра':'Quick play' }}</a>
            </aside>
            <section class="nx-card nx-server-table" data-server-browser>
                <div class="nx-table-head"><span>{{ app()->getLocale()==='bg'?'Сървър':'Server' }}</span><span>{{ app()->getLocale()==='bg'?'Карта':'Map' }}</span><span>{{ app()->getLocale()==='bg'?'Играчи':'Players' }}</span><span>Ping</span><span>{{ app()->getLocale()==='bg'?'Действие':'Action' }}</span></div>
                @forelse($servers as $server)
                    <article class="nx-server-row" data-server-row data-status="{{ $server->status }}" data-game="{{ $server->game }}" data-search="{{ strtolower($server->name.' '.$server->current_map.' '.$server->host) }}">
                        <div class="nx-server-main"><span class="nx-map-thumb" style="background-image:linear-gradient(90deg,transparent,#1110),url('{{ $server->mapArtwork() }}')"></span><span class="nx-server-name"><strong>{{ $server->name }}</strong><small><span class="nx-status {{ $server->status==='online'?'is-online':'is-offline' }}">{{ $server->status }}</span> · {{ strtoupper($server->game) }} · <button class="nx-copy" data-copy-server="{{ $server->host }}:{{ $server->port }}">{{ $server->host }}:{{ $server->port }}</button></small></span></div>
                        <div><span class="nx-cell-label">Map</span><strong class="text-[11px]">{{ $server->current_map ?: '—' }}</strong></div>
                        <div><span class="nx-cell-label">Players</span><strong class="text-[11px]">{{ $server->players_online }}/{{ $server->players_max }}</strong><div class="nx-progress"><i style="width:{{ $server->players_max?min(100,round(($server->players_online/$server->players_max)*100)):0 }}%"></i></div></div>
                        <div><span class="nx-cell-label">Ping</span><strong class="text-[11px]">{{ $server->latency_ms ?? '—' }} ms</strong></div>
                        <a class="nx-button min-h-9 px-3" href="steam://connect/{{ $server->host }}:{{ $server->port }}">Connect</a>
                    </article>
                @empty<div class="p-16 text-center text-xs text-slate-500">{{ app()->getLocale()==='bg'?'Няма добавени сървъри.':'No servers configured.' }}</div>@endforelse
            </section>
        </div>
        @if($servers->hasPages())<div class="mt-5">{{ $servers->links() }}</div>@endif
    </div>
</div>
</x-layouts.app>
