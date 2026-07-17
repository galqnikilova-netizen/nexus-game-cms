@extends('layouts.app')
@section('title', 'Лидерборд — NEXUS')
@section('content')
@include('partials.page-header', ['eyebrow'=>'COMPETITIVE RANKING','title'=>'Лидерборд','description'=>'Класация на най-добрите играчи във всички NEXUS сървъри.'])
<section class="podium-grid">
@foreach(array_slice($players,0,3) as $player)
<article class="podium-card podium-{{ $player['rank'] }}"><span class="podium-rank">#{{ $player['rank'] }}</span><span class="avatar avatar-xl avatar-gradient">{{ strtoupper(substr($player['name'],0,2)) }}</span><h3>{{ $player['name'] }}</h3><small>{{ $player['steam'] }}</small><strong>{{ number_format($player['rating']) }} <em>RATING</em></strong><div><span>{{ $player['kills'] }} K</span><span>{{ $player['kd'] }} K/D</span><span>{{ $player['wins'] }} W</span></div></article>
@endforeach
</section>
<section class="panel data-panel">
<div class="data-toolbar"><div class="input-shell">@svg('search')<input placeholder="Търси играч..."></div><div class="select-shell">@svg('server')<select><option>Всички сървъри</option><option>PUBLIC</option><option>RETAKES</option></select></div><button class="button button-muted">@svg('filter') Филтри</button></div>
<div class="responsive-table"><table><thead><tr><th>#</th><th>Играч</th><th>Rating</th><th>Kills</th><th>K/D</th><th>Победи</th><th>Време</th><th>Промяна</th></tr></thead><tbody>
@foreach($players as $player)<tr><td><span class="rank-cell">{{ $player['rank'] }}</span></td><td><a class="player-cell" href="{{ route('profile', $player['steam']) }}"><span class="avatar avatar-sm avatar-dark">{{ strtoupper(substr($player['name'],0,2)) }}</span><span><strong>{{ $player['name'] }}</strong><small><i class="presence presence-{{ $player['status'] }}"></i>{{ $player['steam'] }}</small></span></a></td><td><b class="rating-cell">{{ number_format($player['rating']) }}</b></td><td>{{ number_format($player['kills']) }}</td><td>{{ $player['kd'] }}</td><td>{{ $player['wins'] }}</td><td>{{ $player['hours'] }} ч.</td><td><span class="trend {{ str_starts_with($player['trend'],'-') ? 'down' : 'up' }}">{{ $player['trend'] }}</span></td></tr>@endforeach
</tbody></table></div>
</section>
@endsection
