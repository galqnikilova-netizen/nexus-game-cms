<x-layouts.app title="{{ $user->name }} · NEXUS">
<div class="nx-page-pad"><div class="nx-shell">
    <div class="neo-profile-layout">
        <aside class="nx-card neo-profile-card">
            <div class="neo-profile-cover">@if($user->avatar_url)<img src="{{ $user->avatar_url }}" alt="">@else<span>{{ mb_substr($user->name,0,1) }}</span>@endif</div>
            <div class="neo-profile-identity"><strong>{{ $user->name }}</strong><small>{{ $user->last_login_at?->diffForHumans()?:'NEXUS member' }}</small>@if($user->profile_url)<a href="{{ $user->profile_url }}" target="_blank">Open Steam profile ↗</a>@endif</div>
            <div class="neo-profile-rank"><span>LEVEL</span><strong>{{ max(1,(int)floor($summary['score']/1000)+1) }}</strong><span>SCORE</span><strong>{{ number_format($summary['score']) }}</strong></div>
            <div class="neo-profile-social"><button>Steam</button><button>Discord</button><button>Friends</button></div>
        </aside>
        <main class="nx-card neo-profile-data">
            <header><span class="nx-kicker">Player information</span><h2>{{ app()->getLocale()==='bg'?'Информация за играча':'Player information' }}</h2></header>
            <section><h3>{{ app()->getLocale()==='bg'?'Местоположение':'Location' }}</h3><div class="neo-data-grid"><span><small>COUNTRY</small><b>{{ strtoupper($user->locale) }}</b></span><span><small>VISIBILITY</small><b>PUBLIC</b></span><span><small>MEMBER SINCE</small><b>{{ $user->created_at->format('d.m.Y') }}</b></span></div></section>
            <section><h3>{{ app()->getLocale()==='bg'?'Статистика':'Statistics' }}</h3><div class="neo-data-grid neo-data-six"><span><small>SCORE</small><b>{{ number_format($summary['score']) }}</b></span><span><small>KILLS</small><b>{{ number_format($summary['kills']) }}</b></span><span><small>DEATHS</small><b>{{ number_format($summary['deaths']) }}</b></span><span><small>K/D</small><b>{{ $summary['deaths']?number_format($summary['kills']/$summary['deaths'],2):number_format($summary['kills'],2) }}</b></span><span><small>HEADSHOTS</small><b>{{ number_format($summary['headshots']) }}</b></span><span><small>PLAYTIME</small><b>{{ intdiv($summary['playtime'],60) }}h</b></span></div></section>
            <section><h3>Steam ID</h3><div class="neo-steam-ids"><code>{{ $user->steam_id?'STEAM64: '.$user->steam_id:'NOT CONNECTED' }}</code><button data-copy-server="{{ $user->steam_id }}">Copy</button></div></section>
            @if($user->playerStats->isNotEmpty())<section><h3>{{ app()->getLocale()==='bg'?'Статистика по сървъри':'Server statistics' }}</h3>@foreach($user->playerStats as $stat)<div class="neo-profile-server"><span><b>{{ $stat->server?->name?:'Global' }}</b><small>{{ $stat->last_seen_at?->diffForHumans()?:'No session' }}</small></span><strong>{{ number_format($stat->score) }} pts</strong></div>@endforeach</section>@endif
        </main>
    </div>
</div></div>
</x-layouts.app>
