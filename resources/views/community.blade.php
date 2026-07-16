<x-layouts.app title="Общност · NEXUS">
    <section class="portal-subhead"><div class="portal-shell"><div class="portal-breadcrumb"><a href="{{ route('home') }}">HOME</a><span>/</span><b>COMMUNITY</b></div><small>MEMBER NETWORK</small><h1>OUR COMMUNITY</h1><p>Играчите, които изграждат NEXUS мрежата.</p></div></section>
    <div class="portal-shell portal-page-grid">
        <x-portal-sidebar />
        <main class="portal-page-main">
            <header class="portal-heading"><div><small>MEMBER DIRECTORY</small><h2>LATEST MEMBERS</h2></div><b>{{ number_format($memberCount) }} REGISTERED</b></header>
            <div class="community-summary-strip"><span><small>REGISTERED</small><b>{{ number_format($memberCount) }}</b></span><span><small>STEAM IDENTITY</small><b>ACTIVE</b></span><span><small>TRUST SYSTEM</small><b>ONLINE</b></span></div>
            <div class="portal-member-list">
                @forelse($members as $member)
                    <a href="{{ route('profile.show', $member) }}"><div class="member-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>@if($member->avatar_url)<img src="{{ $member->avatar_url }}" alt="">@else<span class="member-letter">{{ mb_substr($member->name, 0, 1) }}</span>@endif<div><b>{{ $member->name }}</b><small>{{ $member->steam_id ? 'STEAM VERIFIED PLAYER' : 'NEXUS MEMBER' }}</small></div><time>JOINED {{ $member->created_at->format('d.m.Y') }}</time><i>→</i></a>
                @empty
                    <div class="portal-empty"><b>THE COMMUNITY IS WAITING FOR YOU</b><p>Свържи Steam профила си и бъди първият играч.</p><a href="{{ route('auth.steam') }}">CONNECT STEAM →</a></div>
                @endforelse
            </div>
        </main>
    </div>
</x-layouts.app>
