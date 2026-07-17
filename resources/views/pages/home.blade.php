@extends('layouts.neo3')
@section('title', 'NEXUS — Начало')
@section('content')
@php
    $feed = [
        ['name' => 'toxic.exe', 'type' => 'punishment', 'text' => 'Обиди и провокации', 'time' => 'преди 3 мин.', 'icon' => 'gavel'],
        ['name' => 'k0bra', 'type' => 'buy', 'text' => 'NEXUS PRIME · 30 дни', 'time' => 'преди 8 мин.', 'icon' => 'store'],
        ['name' => 'xFury', 'type' => 'online', 'text' => 'Влезе в PUBLIC #1', 'time' => 'преди 12 мин.', 'icon' => 'play'],
        ['name' => 'WallHack?', 'type' => 'punishment', 'text' => 'Непозволен софтуер', 'time' => 'преди 17 мин.', 'icon' => 'shield'],
        ['name' => 'Luna', 'type' => 'buy', 'text' => '500 NEXUS Coins', 'time' => 'преди 22 мин.', 'icon' => 'sparkles'],
        ['name' => 'm1rage', 'type' => 'online', 'text' => 'Влезе в RETAKES', 'time' => 'преди 28 мин.', 'icon' => 'users'],
    ];
    $modes = [
        ['name' => 'PUBLIC', 'players' => 48, 'servers' => 4, 'desc' => 'Класически public сървъри'],
        ['name' => 'RETAKES', 'players' => 31, 'servers' => 3, 'desc' => 'Бързи retake рундове'],
        ['name' => 'AWP', 'players' => 22, 'servers' => 2, 'desc' => 'AWP арени и тренировка'],
        ['name' => 'ARENA', 'players' => 18, 'servers' => 2, 'desc' => '1v1 competitive арени'],
    ];
    $drops = [
        ['name'=>'ROG_STRIX','reward'=>'25 NEXUS Coins'], ['name'=>'xFury','reward'=>'VIP за 24 часа'], ['name'=>'m1rage','reward'=>'10 NEXUS Coins'],
        ['name'=>'Luna','reward'=>'Rare card'], ['name'=>'Vortex','reward'=>'50 NEXUS Coins'], ['name'=>'k0bra','reward'=>'Skin preset'],
        ['name'=>'n0scope','reward'=>'5 NEXUS Coins'], ['name'=>'deadinside','reward'=>'Premium card'],
    ];
@endphp

@include('pages.home.stage1-01')
@include('pages.home.stage1-02')
@include('pages.home.stage1-03')
@include('pages.home.stage1-04')
@include('pages.home.stage1-05')
@include('pages.home.stage1-06')
@include('pages.home.stage1-07')
@include('pages.home.stage1-08')
@endsection
