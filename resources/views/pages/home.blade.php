@extends('layouts.app')
@section('title', 'NEXUS — Начало')
@section('content')
<section class="hero-panel">
    <div class="hero-copy">
        <span class="eyebrow"><i></i> NEXUS NETWORK</span>
        <h1>Твоят gaming проект.<br><em>На следващо ниво.</em></h1>
        <p>Една система за сървъри, играчи, статистика, магазин, наказания и поддръжка — с премиум интерфейс на всяко устройство.</p>
        <div class="hero-actions">
            <a class="button button-primary" href="#servers">@svg('play') Играй сега</a>
            <a class="button button-ghost" href="{{ route('store') }}">Разгледай магазина @svg('arrow')</a>
        </div>
        <div class="hero-trust"><span class="avatar-stack"><b>RS</b><b>XF</b><b>MI</b><b>+9</b></span><span><strong>1 248 играчи</strong><small>са онлайн в момента</small></span></div>
    </div>
    <div class="hero-visual">
        <div class="orb orb-one"></div><div class="orb orb-two"></div>
        <div class="hero-console">
            <div class="console-top"><span><i></i> LIVE SERVER</span><em>EU / SOFIA</em></div>
            <div class="console-map"><span class="map-grid"></span><div><small>Сега се играе</small><strong>DE_MIRAGE</strong><span>NEXUS #1 PUBLIC</span></div><b>28<small>/32</small></b></div>
            <div class="console-players">
                @foreach(array_slice($servers, 0, 3) as $index => $server)
                <div><span class="mini-avatar">{{ ['RS','XF','M1'][$index] }}</span><strong>{{ ['ROG_STRIX','xFury','m1rage'][$index] }}</strong><em>{{ [42,35,31][$index] }} K</em><i style="--w: {{ [92,78,66][$index] }}%"></i></div>
                @endforeach
            </div>
        </div>
        <div class="floating-card fc-one"><span>@svg('bolt')</span><div><small>Server latency</small><strong>18 ms</strong></div></div>
        <div class="floating-card fc-two"><span>@svg('shield')</span><div><small>Anti-cheat</small><strong>Protected</strong></div></div>
    </div>
</section>

<section class="stats-grid">
@foreach($stats as $stat)
    <article class="stat-card"><span class="stat-icon">@svg($stat['icon'])</span><div><small>{{ $stat['label'] }}</small><strong>{{ $stat['value'] }}</strong><em>{{ $stat['meta'] }}</em></div></article>
@endforeach
</section>

<section class="section-block" id="servers">
    <div class="section-heading"><div><span class="eyebrow">БЪРЗА ИГРА</span><h2>Избери сървър</h2></div><div class="segmented"><button class="is-active">Всички</button><button>CS2</button><button>CS 1.6</button></div></div>
    <div class="server-grid">
    @foreach($servers as $server)
        <article class="server-card accent-{{ $server['accent'] }}">
            <div class="server-cover"><span class="server-map-art"></span><div class="server-badges"><span><i></i> ONLINE</span><em>{{ $server['mode'] }}</em></div><strong>{{ strtoupper($server['map']) }}</strong></div>
            <div class="server-body"><div class="server-title"><div><small>{{ $server['mode'] }} / EU</small><h3>{{ $server['name'] }}</h3></div><span class="ping"><i></i>{{ $server['ping'] }} ms</span></div>
            <div class="server-capacity"><span><b>{{ $server['players'] }}</b> / {{ $server['slots'] }} играчи</span><em>{{ round($server['players'] / $server['slots'] * 100) }}%</em><i style="--fill: {{ round($server['players'] / $server['slots'] * 100) }}%"></i></div>
            <div class="server-actions"><button class="button button-muted button-icon" data-copy="connect play.nexus.bg:2701{{ $loop->iteration }}" aria-label="Копирай IP">@svg('copy')</button><button class="button button-primary flex-1">@svg('play') Присъедини се</button></div></div>
        </article>
    @endforeach
    </div>
</section>

<section class="two-column">
    <article class="panel">
        <div class="panel-heading"><div><span class="eyebrow">SECURITY FEED</span><h2>Последни наказания</h2></div><a href="{{ route('punishments') }}">Покажи всички @svg('arrow')</a></div>
        <div class="activity-list">
        @foreach($punishments as $row)
            <div class="activity-row"><span class="avatar avatar-dark">{{ strtoupper(substr($row['player'],0,2)) }}</span><div class="activity-copy"><strong>{{ $row['player'] }}</strong><span>{{ $row['reason'] }} · {{ $row['server'] }}</span></div><div class="activity-side"><b class="badge badge-{{ $row['status'] }}">{{ $row['duration'] }}</b><small>{{ $row['time'] }}</small></div></div>
        @endforeach
        </div>
    </article>
    <article class="panel">
        <div class="panel-heading"><div><span class="eyebrow">STORE ACTIVITY</span><h2>Последни покупки</h2></div><a href="{{ route('store') }}">Магазин @svg('arrow')</a></div>
        <div class="activity-list purchases-list">
        @foreach($purchases as $row)
            <div class="activity-row"><span class="avatar avatar-gradient">{{ strtoupper(substr($row['name'],0,2)) }}</span><div class="activity-copy"><strong>{{ $row['name'] }}</strong><span>{{ $row['product'] }}</span></div><div class="activity-side"><b class="price-text">{{ $row['price'] }}</b><small>{{ $row['time'] }}</small></div></div>
        @endforeach
        </div>
        <div class="mini-banner"><span>@svg('sparkles')</span><div><strong>Вземи NEXUS PASS</strong><small>Всички premium функции в един пакет.</small></div><a href="{{ route('store') }}">Виж</a></div>
    </article>
</section>
@endsection
