<div class="row" id="rowServers">
    <div class="col-md-12">
        <div class="subMod subMod--inline"><span class="subMod__title">NEXUS NETWORK</span><div class="subMod__counter"><span>{{ collect($servers)->sum('players') }}</span> играчи</div><div class="subMod__dashed"></div><div class="subMod__servers"><span>{{ count($servers) }}</span> сървъра</div></div>
        <div class="servers__card-wrapper-4">
            @foreach($servers as $server)
                @php($fill = round($server['players'] / max($server['slots'], 1) * 100))
                <article class="servers__card-block" id="server-mode-{{ $loop->index }}" data-mode="{{ $server['mode'] }}" data-map="{{ $server['map'] }}">
                    <div class="servers__card-online server_play_access-{{ $loop->index }}"><div class="servers__card-online-line" style="width:{{ $fill }}%"></div></div>
                    <div class="servers__card-info">
                        <div class="servers__card-header">
                            <div class="servers__card-isActive"><div class="servers__card-ping"><span class="server-ping">{{ $server['ping'] }} ms</span></div><span class="server__card-dot-decor">•</span></div>
                            <span class="server__card-name">{{ $server['name'] }}</span>
                        </div>
                        <div class="servers__card-details">
                            <span class="servers__card-badge">{{ $server['mode'] }}</span>
                            <button type="button" class="toFavourite" aria-label="Добави в любими">@svg('sparkles')</button>
                            <span class="servers__card-map">{{ $server['map'] }}</span><span class="server__card-dot-decor">•</span><span class="servers__card-online-text">{{ $server['players'] }}/{{ $server['slots'] }}</span>
                        </div>
                    </div>
                    <div class="servers__card-buttons neo3-server-actions">
                        <button class="copy-btn" type="button" data-copy="connect play.nexus.bg:270{{ 10 + $loop->iteration }}" aria-label="Копирай IP">@svg('copy')</button>
                        <a href="steam://connect/play.nexus.bg:270{{ 10 + $loop->iteration }}" aria-label="Влез в сървъра">@svg('play')</a>
                    </div>
                    <div class="neo3-map-art"></div>
                </article>
            @endforeach
        </div>
    </div>
</div>
