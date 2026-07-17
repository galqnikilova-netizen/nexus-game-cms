@extends('layouts.neo3')
@section('title', 'Лидерборд — NEXUS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/neo3-leaderboard.css') }}">
@endpush

@section('content')
@php
    $me = $players[0];
    $servers = ['Всички сървъри', 'PUBLIC', 'RETAKES', 'AWP', 'ARENA'];
@endphp
<div class="row neo3-leaderboard-page" data-neo3-leaderboard>
    <div class="col-md-3 fix-width-tablet">
        <div class="card sticky-filter">
            <div class="card-header">
                <h5 class="badge">Информация</h5>
                <span class="neo3-leaderboard-summary"><b>{{ count($players) }}</b> играчи</span>
            </div>
            <div class="card-container">
                <div id="userStatsContainer">
                    <div class="leaderboard__my-stat">
                        <div class="leaderboard__my-stat-header">
                            <div class="leaderboard__my-stat-text">
                                <div class="leaderboard__my-stat-hello-text">Здравей, <span class="leaderboard__my-stat-nickname">{{ $me['name'] }}</span></div>
                                <div class="leaderboard__my-stat-description">Твоята игрова статистика</div>
                            </div>
                            <span class="leaderboard__my-stat-rank">#{{ $me['rank'] }}</span>
                        </div>
                        <div class="leaderboard__my-stat-info">
                            <div class="leaderboard__my-stat-line-1">
                                <span class="leaderboard__my-stat-avatar">{{ strtoupper(substr($me['name'], 0, 2)) }}</span>
                                <div class="leaderboard__my-stat-block"><span class="leaderboard__my-stat-title">Място</span><span class="leaderboard__my-stat-value">{{ $me['rank'] }}</span></div>
                                <div class="leaderboard__my-stat-block"><span class="leaderboard__my-stat-title">Точки</span><span class="leaderboard__my-stat-value">{{ number_format($me['rating']) }}</span></div>
                                <div class="leaderboard__my-stat-block"><span class="leaderboard__my-stat-title">K/D</span><span class="leaderboard__my-stat-value">{{ $me['kd'] }}</span></div>
                            </div>
                            <div class="leaderboard__my-stat-line-2">
                                <div class="leaderboard__my-stat-block"><span class="leaderboard__my-stat-title">Убийства</span><span class="leaderboard__my-stat-value">{{ number_format($me['kills']) }}</span></div>
                                <div class="leaderboard__my-stat-block"><span class="leaderboard__my-stat-title">Смърти</span><span class="leaderboard__my-stat-value">{{ number_format($me['deaths']) }}</span></div>
                                <div class="leaderboard__my-stat-block"><span class="leaderboard__my-stat-title">В глава</span><span class="leaderboard__my-stat-value">{{ $me['headshots'] }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="inputs-inline leaderboard-filter-search">
                    <label for="leaderboardSearch">Търси играч</label>
                    <div class="input-form flex-inline">@svg('search')<input id="leaderboardSearch" type="search" placeholder="Nickname или Steam ID" autocomplete="off"></div>
                </div>

                <div class="inputs-inline">
                    <label>Избери сървър</label>
                    <div class="adaptive-select-wrapper">
                        <select id="leaderboardServer" class="adaptive-select neo3-native-select" aria-label="Избери сървър">
                            @foreach($servers as $server)<option value="{{ $server === 'Всички сървъри' ? 'all' : $server }}">{{ $server }}</option>@endforeach
                        </select>
                    </div>
                </div>

                <fieldset class="leaderboard__fieldset">
                    <legend>Сортирай по:</legend>
                    <div class="leaderboard__form" id="leaderboardSort">
                        @foreach([
                            'rating'=>'Игрови точки','kills'=>'Убийства','deaths'=>'Смърти','kd'=>'K/D','headshots'=>'Убийства в глава','hours'=>'Изиграно време','last_seen'=>'Последна сесия'
                        ] as $key=>$label)
                        <div class="inputs-inline"><label class="leaderboard__form-label"><input type="radio" name="leaderboard_sort" value="{{ $key }}" @checked($key==='rating')>{{ $label }}</label></div>
                        @endforeach
                        <button class="button-delete width-100" id="resetLeaderboard" type="button">Нулирай филтъра</button>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Друго</legend>
                    <div class="inputs-inline"><input class="switch" id="leaderboardOnline" type="checkbox"><label for="leaderboardOnline">Само онлайн</label></div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="col-md-9 fix-width-tablet">
        <div class="table-responsive" id="contentTable">
            <table class="table">
                <thead>
                    <tr><th>#</th><th>LVL</th><th style="width:242px">Играч</th><th style="width:130px">Звание</th><th>Точки</th><th>Убийства</th><th>Смърти</th><th>K/D</th><th>В глава</th><th>Изиграл</th><th>Последна игра</th></tr>
                </thead>
                <tbody id="leaderboardTableBody">
                    @foreach($players as $player)
                    <tr class="pointer {{ $player['rank'] <= 3 ? 'leaderboard__table-top-background-'.$player['rank'] : '' }}" data-rank="{{ $player['rank'] }}" data-name="{{ strtolower($player['name'].' '.$player['steam']) }}" data-server="{{ $player['server'] }}" data-status="{{ $player['status'] }}" data-rating="{{ $player['rating'] }}" data-kills="{{ $player['kills'] }}" data-deaths="{{ $player['deaths'] }}" data-kd="{{ $player['kd'] }}" data-headshots="{{ $player['headshots'] }}" data-hours="{{ $player['hours'] }}" data-last_seen="{{ $player['last_seen_order'] }}" onclick="location.href='{{ route('profile', $player['steam']) }}'">
                        <td><div class="leaderboard__table-place {{ $player['rank'] <= 3 ? 'leaderboard__table-top-img-'.$player['rank'] : '' }}">{{ $player['rank'] }}</div></td>
                        <td><span class="leaderboard__table-faceit">{{ $player['level'] }}</span></td>
                        <td>
                            <div class="leaderboard__table-user">
                                <span class="top_players_avatar {{ $player['rank'] <= 3 ? 'leaderboard__table-top-border-'.$player['rank'] : '' }}">{{ strtoupper(substr($player['name'],0,2)) }}</span>
                                <span class="user_online_status"></span>
                                <span class="leaderboard__table-nickname">
                                    <span class="leaderboard__nick-hidden {{ $player['rank'] <= 3 ? 'leaderboard__table-top-nick-'.$player['rank'] : '' }}">{{ $player['name'] }}</span>
                                    <small class="neo3-leaderboard-steam">{{ $player['steam'] }}</small>
                                </span>
                                <span class="leaderboard__badges">@if($player['vip'])<span title="VIP">@svg('sparkles')</span>@endif @if($player['admin'])<span title="Admin">@svg('shield')</span>@endif</span>
                            </div>
                        </td>
                        <td><span class="leaderboard__table-rank-name"><i class="neo3-rank-mark">{{ $player['rank_short'] }}</i>{{ $player['rank_name'] }}</span></td>
                        <td class="leaderboard__table-grey-text">{{ number_format($player['rating']) }}</td>
                        <td class="leaderboard__table-grey-text">{{ number_format($player['kills']) }}</td>
                        <td class="leaderboard__table-grey-text">{{ number_format($player['deaths']) }}</td>
                        <td class="leaderboard__table-grey-text">{{ number_format($player['kd'],2) }}</td>
                        <td class="leaderboard__table-grey-text">{{ $player['headshots'] }}%</td>
                        <td class="leaderboard__table-grey-text">{{ $player['hours'] }} ч.</td>
                        <td class="leaderboard__table-grey-text">{{ $player['last_seen'] }}</td>
                    </tr>
                    @endforeach
                    <tr class="neo3-empty-row" hidden><td colspan="11">Няма намерени играчи.</td></tr>
                </tbody>
            </table>
        </div>
        <div class="neo3-pagination" aria-label="Страници"><button type="button" class="button-delete">1</button><button type="button">2</button><button type="button">3</button></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/neo3-stage2.js') }}" defer></script>
@endpush
