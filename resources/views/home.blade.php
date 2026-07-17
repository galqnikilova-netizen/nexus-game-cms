<x-layouts.app title="{{ $nexusAppearance['site_name'] }}">
    <section class="portal-subhead portal-home-subhead">
        <div class="portal-shell"><div class="portal-breadcrumb"><b>HOME</b></div><small>NEXUS NETWORK</small><h1>{{ __('ui.hero.title') }} {{ __('ui.hero.accent') }}</h1><p>{{ __('ui.hero.copy') }}</p></div>
    </section>

    <div class="portal-shell portal-page-grid">
        <x-portal-sidebar />
        <main class="portal-page-main portal-home-content">
            <article class="portal-slider">
                <div class="slide-overlay"><span>FEATURED / NEXUS NETWORK</span><h1>PLAY. COMPETE.<br>BELONG.</h1><p>Собствена gaming общност със live сървъри, Steam профили, роли, наказания и услуги.</p><a href="{{ route('servers.index') }}">ENTER THE SERVERS <b>→</b></a></div>
                <div class="slide-tabs"><b>01</b><span></span><i>03</i></div>
            </article>

            <header class="portal-heading"><div><small>LATEST UPDATES</small><h2>COMMUNITY NEWS</h2></div><a href="{{ route('community.index') }}">VIEW ALL</a></header>
            @forelse($posts as $post)
                <article class="portal-news {{ $loop->first ? 'featured' : '' }}">@if($loop->first)<a class="news-thumb home-news-cover" href="{{ route('news.show',$post) }}" @if($post->imageUrl()) style="--news-image:url('{{ $post->imageUrl() }}')" @endif><b>NX</b><span>{{ strtoupper($post->category) }}</span></a>@else<time><b>{{ $post->published_at->format('d') }}</b>{{ strtoupper($post->published_at->format('M')) }}</time>@endif<div><small>{{ $post->published_at->format('d M Y') }} · {{ strtoupper($post->category) }}</small><h3>{{ $post->title }}</h3><p>{{ $post->excerpt }}</p><footer><a href="{{ route('news.show',$post) }}">READ MORE →</a></footer></div></article>
            @empty
                <article class="portal-news featured"><div class="news-thumb"><b>NX</b><span>NEWS</span></div><div><small>CONTENT MANAGER</small><h3>Очаквайте първата NEXUS новина</h3><p>Публикациите от контролния панел ще се показват автоматично тук.</p></div></article>
            @endforelse

            <header class="portal-heading"><div><small>LIVE STATUS</small><h2>GAME SERVERS</h2></div><a href="{{ route('servers.index') }}">VIEW ALL SERVERS</a></header>
            <section class="portal-home-servers">
                @forelse($servers as $server)
                    <a class="portal-server home-map-server" href="{{ route('servers.index') }}"><span style="--map-art:url('{{ $server->mapArtwork() }}')"><i>{{ strtoupper(substr($server->game, 0, 2)) }}</i></span><div><b>{{ $server->name }}</b><small>{{ $server->current_map ?? $server->host.':'.$server->port }}</small><em><i style="width:{{ $server->players_max ? min(100, ($server->players_online / $server->players_max) * 100) : 0 }}%"></i></em></div><strong>{{ $server->players_online }}<small>/{{ $server->players_max }}</small></strong></a>
                @empty
                    <div class="portal-server-empty">No servers configured yet.</div>
                @endforelse
            </section>
        </main>
    </div>
</x-layouts.app>
