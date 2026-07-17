@extends('layouts.neo3')
@section('title', $player['name'].' — NEXUS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/neo3-leaderboard.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/neo3-profile.css') }}">
@endpush

@section('content')
<div class="row neo3-profile-page" data-neo3-profile>
    <div class="col-md-3 fix-width-tablet">
        <div class="card sticky-filter">
            <div class="card-header"><h5 class="badge">Профил на играч</h5></div>
            <div class="card-container">
                <div class="neo3-profile-identity">
                    <span class="neo3-profile-avatar">{{ strtoupper(substr($player['name'],0,2)) }}</span>
                    <div class="neo3-profile-name"><h1>{{ $player['name'] }}</h1><span>{{ $player['steam'] }}</span></div>
                    <span class="neo3-profile-rank">#{{ $player['rank'] }}</span>
                </div>
                <div class="neo3-profile-mini-grid">
                    <div class="neo3-profile-mini"><small>Звание</small><strong>{{ $player['rank_name'] }}</strong></div>
                    <div class="neo3-profile-mini"><small>Level</small><strong>{{ $player['level'] }}</strong></div>
                    <div class="neo3-profile-mini"><small>Сървър</small><strong>{{ $player['server'] }}</strong></div>
                    <div class="neo3-profile-mini"><small>Изиграл</small><strong>{{ $player['hours'] }} ч.</strong></div>
                </div>
                <nav class="neo3-profile-nav" aria-label="Профилни секции">
                    <button class="active" type="button" data-profile-tab="overview">@svg('home') Преглед</button>
                    <button type="button" data-profile-tab="matches">@svg('chart') Мачове</button>
                    <button type="button" data-profile-tab="weapons">@svg('bolt') Оръжия</button>
                    <button type="button" data-profile-tab="achievements">@svg('trophy') Отличия</button>
                </nav>
                <div class="neo3-profile-status"><i></i><span>Онлайн в {{ $player['server'] }}</span></div>
            </div>
        </div>
    </div>

    <div class="col-md-9 fix-width-tablet">
        <section class="neo3-profile-panel" data-profile-panel="overview">
            <article class="card neo3-profile-hero">
                <div class="card-container">
                    <div class="neo3-profile-hero-copy"><span class="neo3-profile-kicker">NEXUS VERIFIED PLAYER</span><h2>{{ $player['name'] }}</h2><p>Статистика от NEXUS сървърите, синхронизирана с последната игрова сесия. Профилът използва същата Neo3 структура, карти и филтри като останалата система.</p></div>
                    <div class="neo3-profile-rating"><small>NEXUS RATING</small><strong>{{ number_format($player['rating']) }}</strong><span>{{ $player['trend'] }} тази седмица</span></div>
                </div>
            </article>
            <div class="neo3-profile-stat-grid">
                <article class="neo3-profile-stat">@svg('bolt')<small>Убийства</small><strong>{{ number_format($player['kills']) }}</strong><span>{{ $player['kills_month'] }} този месец</span></article>
                <article class="neo3-profile-stat">@svg('chart')<small>K/D</small><strong>{{ number_format($player['kd'],2) }}</strong><span>Топ {{ $player['top_percent'] }}%</span></article>
                <article class="neo3-profile-stat">@svg('trophy')<small>Победи</small><strong>{{ $player['wins'] }}</strong><span>{{ $player['win_rate'] }}% win rate</span></article>
                <article class="neo3-profile-stat">@svg('shield')<small>Headshots</small><strong>{{ $player['headshots'] }}%</strong><span>{{ $player['headshot_kills'] }} общо</span></article>
            </div>
            <article class="card neo3-profile-section">
                <div class="card-header"><h5 class="badge">Последни мачове</h5><span class="neo3-profile-section-note">Последните 4 игрови сесии</span></div>
                @include('pages.profile-sections.matches')
            </article>
        </section>

        <section class="neo3-profile-panel" data-profile-panel="matches" hidden>
            <article class="card neo3-profile-section">
                <div class="card-header"><h5 class="badge">История на мачовете</h5><span class="neo3-profile-section-note">Резултати, K/D и промяна в рейтинга</span></div>
                @include('pages.profile-sections.matches')
            </article>
        </section>

        <section class="neo3-profile-panel" data-profile-panel="weapons" hidden>
            <article class="card neo3-profile-section">
                <div class="card-header"><h5 class="badge">Топ оръжия</h5><span class="neo3-profile-section-note">Точност и убийства</span></div>
                <div class="neo3-weapon-list">
                    @foreach($weaponStats as $weapon)
                    <div class="neo3-weapon-card"><span class="neo3-weapon-art">{{ $weapon['name'] }}</span><div class="neo3-weapon-info"><strong>{{ $weapon['skin'] }}</strong><small>{{ $weapon['kills'] }} убийства · {{ $weapon['accuracy'] }}% точност</small><span class="neo3-weapon-progress"><i style="--w:{{ $weapon['accuracy'] }}%"></i></span></div><div class="neo3-weapon-value"><strong>{{ $weapon['headshots'] }}%</strong><small>HEADSHOTS</small></div></div>
                    @endforeach
                </div>
            </article>
        </section>

        <section class="neo3-profile-panel" data-profile-panel="achievements" hidden>
            <article class="card neo3-profile-section">
                <div class="card-header"><h5 class="badge">Отличия</h5><span class="neo3-profile-section-note">Постижения в NEXUS</span></div>
                <div class="neo3-achievement-grid">
                    @foreach($achievements as $achievement)
                    <div class="neo3-achievement"><span class="neo3-achievement-icon">@svg($achievement['icon'])</span><div><strong>{{ $achievement['name'] }}</strong><small>{{ $achievement['description'] }}</small></div></div>
                    @endforeach
                </div>
            </article>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/neo3-stage2.js') }}" defer></script>
@endpush
