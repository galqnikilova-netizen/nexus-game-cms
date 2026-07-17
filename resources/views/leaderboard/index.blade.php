<x-layouts.app title="{{ app()->getLocale()==='bg'?'Класация':'Leaderboard' }} · NEXUS">
<div class="nx-page-pad"><div class="nx-shell">
    <div class="nx-section-head"><div><span class="nx-kicker">Player statistics</span><h2>{{ app()->getLocale()==='bg'?'Класация на играчите':'Player leaderboard' }}</h2></div><span class="nx-live-pill"><i class="nx-live-dot"></i>{{ $stats->total() }} ranked players</span></div>
    <div class="nx-content-grid">
        <aside class="nx-card nx-filter-panel">
            @auth<div class="neo-mini-profile">@if(auth()->user()->avatar_url)<img src="{{ auth()->user()->avatar_url }}" alt="">@else<span>{{ mb_substr(auth()->user()->name,0,1) }}</span>@endif<div><b>{{ auth()->user()->name }}</b><small>{{ auth()->user()->steam_id?:'NEXUS MEMBER' }}</small></div><strong>#{{ optional(auth()->user()->playerStats()->orderByDesc('score')->first())->score?:0 }}</strong></div>@endauth
            <form method="GET">
                <label class="nx-filter-label">{{ app()->getLocale()==='bg'?'Избери сървър':'Select server' }}</label><select class="nx-input" name="server" onchange="this.form.submit()"><option value="">{{ app()->getLocale()==='bg'?'Всички сървъри':'All servers' }}</option>@foreach($servers as $server)<option value="{{ $server->id }}" @selected($serverId===$server->id)>{{ $server->name }}</option>@endforeach</select>
                <span class="nx-filter-label">{{ app()->getLocale()==='bg'?'Подреди по':'Sort by' }}</span><div class="neo-radio-list">@foreach(['score'=>'Игрови точки','kills'=>'Убийства','deaths'=>'Смърти','headshots'=>'Headshots','playtime_minutes'=>'Време в игра','last_seen_at'=>'Последна сесия'] as $key=>$label)<label><input type="radio" name="sort" value="{{ $key }}" @checked($sort===$key) onchange="this.form.submit()"><i></i><span>{{ $label }}</span></label>@endforeach</div>
                <a class="nx-button-muted mt-4 w-full" href="{{ route('leaderboard.index') }}">{{ app()->getLocale()==='bg'?'Изчисти филтъра':'Reset filter' }}</a>
            </form>
        </aside>
        <section class="nx-card neo-leaderboard">
            <div class="neo-board-head"><span>#</span><span>{{ app()->getLocale()==='bg'?'Играч':'Player' }}</span><span>Rank</span><span>Kills</span><span>Deaths</span><span>K/D</span><span>HS</span><span>Playtime</span></div>
            @forelse($stats as $stat)
                <a class="neo-board-row" href="{{ route('profile.show',$stat->user) }}"><strong>{{ $stats->firstItem()+$loop->index }}</strong><span class="neo-player-cell">@if($stat->user->avatar_url)<img src="{{ $stat->user->avatar_url }}" alt="">@else<i>{{ mb_substr($stat->user->name,0,1) }}</i>@endif<b>{{ $stat->user->name }}</b></span><span><em>{{ $stat->score }}</em>{{ $stat->rank?:'Member' }}</span><span>{{ number_format($stat->kills) }}</span><span>{{ number_format($stat->deaths) }}</span><span>{{ number_format($stat->kd(),2) }}</span><span>{{ $stat->headshotRate() }}%</span><span>{{ intdiv($stat->playtime_minutes,60) }}h</span></a>
            @empty<div class="p-16 text-center"><b class="text-sm">{{ app()->getLocale()==='bg'?'Все още няма статистика':'No player statistics yet' }}</b><p class="mt-2 text-xs text-slate-500">{{ app()->getLocale()==='bg'?'Данните ще се появят след първия parser import.':'Data will appear after the first parser import.' }}</p></div>@endforelse
        </section>
    </div>
    @if($stats->hasPages())<div class="mt-5">{{ $stats->links() }}</div>@endif
</div></div>
</x-layouts.app>
