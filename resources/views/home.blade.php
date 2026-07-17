<x-layouts.app title="{{ $nexusAppearance['site_name'] }}">
@php
    $totalPlayers = $servers->sum('players_online');
    $totalSlots = max(1,$servers->sum('players_max'));
    $onlineServers = $servers->where('status','online')->count();
@endphp
<div class="nx-page-pad">
    <div class="nx-shell">
        <section>
            <div class="nx-section-head">
                <div><span class="nx-kicker">{{ app()->getLocale()==='bg'?'Мрежа в реално време':'Live network' }}</span><h2>{{ app()->getLocale()==='bg'?'Избери своя режим':'Choose your mode' }}</h2></div>
                <div class="nx-tabs" role="tablist"><button class="nx-tab is-active">{{ app()->getLocale()==='bg'?'Сървъри':'Servers' }}</button><button class="nx-tab">{{ app()->getLocale()==='bg'?'Последни наказания':'Latest bans' }}</button><button class="nx-tab">{{ app()->getLocale()==='bg'?'Нови играчи':'New players' }}</button></div>
            </div>
            <div class="nx-server-strip">
                @forelse($servers as $server)
                    <article class="nx-mode-card" style="background-image:url('{{ $server->mapArtwork() }}')">
                        <div class="nx-mode-top"><span class="nx-mode-game">{{ strtoupper($server->game) }}</span><span class="nx-status {{ $server->status==='online'?'is-online':'is-offline' }}">{{ $server->status }}</span></div>
                        <div class="nx-mode-card-content">
                            <h3>{{ $server->name }}</h3>
                            <div class="nx-mode-meta"><span>{{ $server->current_map ?: 'Awaiting query' }}</span><span>{{ $server->latency_ms ? $server->latency_ms.' ms' : '—' }}</span><span class="nx-mode-players">{{ $server->players_online }}<small>/{{ $server->players_max }}</small></span></div>
                            <a href="steam://connect/{{ $server->host }}:{{ $server->port }}" class="absolute inset-0" aria-label="Connect to {{ $server->name }}"></a>
                        </div>
                    </article>
                @empty
                    @foreach(['PUBLIC','AWP ONLY','RETAKE','DEATHMATCH'] as $mode)
                        <article class="nx-mode-card" style="background-image:url('{{ asset('images/maps/'.(['dust','mirage','inferno','nuke'][$loop->index]).'.svg') }}')"><div class="nx-mode-top"><span class="nx-mode-game">CS2</span><span class="nx-status is-offline">offline</span></div><div class="nx-mode-card-content"><h3>{{ $mode }}</h3><div class="nx-mode-meta"><span>{{ app()->getLocale()==='bg'?'Очаква настройка':'Awaiting setup' }}</span><span class="nx-mode-players">0<small>/0</small></span></div></div></article>
                    @endforeach
                @endforelse
            </div>
        </section>

        <section class="mt-3 nx-promo-grid">
            <a class="nx-promo" href="{{ route('community.index') }}" style="--promo:rgba(72,151,255,.33)"><b>{{ app()->getLocale()==='bg'?'Присъедини се към Discord':'Join our Discord' }}</b><span>{{ app()->getLocale()==='bg'?'Новини, събития и директна връзка с екипа':'News, events and direct support' }}</span><i class="nx-promo-icon not-italic">D</i></a>
            <a class="nx-promo" href="{{ route('shop.index') }}" style="--promo:rgba(223,167,71,.27)"><b>{{ app()->getLocale()==='bg'?'VIP и специални услуги':'VIP and premium services' }}</b><span>{{ app()->getLocale()==='bg'?'Подкрепи проекта и отключи повече':'Support the network and unlock more' }}</span><i class="nx-promo-icon not-italic">VIP</i></a>
            <a class="nx-promo" href="{{ route('servers.index') }}" style="--promo:rgba(var(--nx-accent-rgb),.3)"><b>{{ app()->getLocale()==='bg'?'Бърза игра':'Quick play' }}</b><span>{{ $totalPlayers }} {{ app()->getLocale()==='bg'?'играчи са онлайн':'players online now' }}</span><i class="nx-promo-icon not-italic">→</i></a>
        </section>

        <section class="mt-3 nx-dashboard-grid">
            <div class="nx-card nx-news-list">
                <div class="nx-section-head px-5 pt-5"><div><span class="nx-kicker">Community feed</span><h2>{{ app()->getLocale()==='bg'?'Последни новини':'Latest news' }}</h2></div><a href="{{ route('news.index') }}">{{ app()->getLocale()==='bg'?'Всички новини':'View all' }} →</a></div>
                @forelse($posts as $post)
                    <a class="nx-news-row" href="{{ route('news.show',$post) }}"><span class="nx-news-image" @if($post->imageUrl()) style="background-image:url('{{ $post->imageUrl() }}')" @endif></span><span><small class="nx-kicker">{{ $post->category }} · {{ $post->published_at->format('d.m.Y') }}</small><h3>{{ $post->title }}</h3><p>{{ $post->excerpt }}</p></span><i class="nx-row-arrow not-italic">→</i></a>
                @empty
                    <div class="px-5 py-14 text-center text-xs text-slate-500">{{ app()->getLocale()==='bg'?'Добави първата новина от контролния център.':'Publish the first update from Control Center.' }}</div>
                @endforelse
            </div>
            <aside class="nx-stat-stack">
                <section class="nx-card nx-stat-panel"><h3>{{ app()->getLocale()==='bg'?'Статус на мрежата':'Network status' }}</h3><div class="nx-stat-line"><span>{{ app()->getLocale()==='bg'?'Активни сървъри':'Active servers' }}</span><strong>{{ $onlineServers }}/{{ $servers->count() }}</strong></div><div class="nx-stat-line"><span>{{ app()->getLocale()==='bg'?'Играчите заемат':'Player occupancy' }}</span><strong>{{ round(($totalPlayers/$totalSlots)*100) }}%</strong></div><div class="nx-stat-line"><span>{{ app()->getLocale()==='bg'?'Общо онлайн':'Total online' }}</span><strong>{{ $totalPlayers }}</strong></div></section>
                <section class="nx-card nx-stat-panel"><h3>{{ app()->getLocale()==='bg'?'Твоята общност':'Your community' }}</h3><div class="nx-stat-line"><span>Steam identity</span><strong>{{ auth()->check()?'✓':'—' }}</strong></div><div class="nx-stat-line"><span>{{ app()->getLocale()==='bg'?'Профил':'Profile' }}</span><a class="text-[10px] font-bold text-white" href="{{ auth()->check()?route('profile.show',auth()->user()):route('login') }}">{{ auth()->check()?auth()->user()->name:(app()->getLocale()==='bg'?'Вход':'Sign in') }} →</a></div></section>
            </aside>
        </section>
    </div>
</div>
</x-layouts.app>
