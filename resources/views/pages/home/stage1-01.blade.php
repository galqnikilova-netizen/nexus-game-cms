<div class="row" data-neo-tabs>
    <div class="col-md-12">
        <h3 class="es__h3">Разширена статистика</h3>
        <div class="es__buttons">
            <button class="filter active" type="button" data-neo-tab="punishments">Последни наказания</button>
            <button class="filter" type="button" data-neo-tab="buys">Последни покупки</button>
            <button class="filter" type="button" data-neo-tab="visits">Днес посетиха</button>
            <button class="filter" type="button" data-neo-tab="online">Сега онлайн</button>
        </div>
        <div class="es__content">
            @foreach(['punishments','buys','visits','online'] as $panel)
                <div class="es__scroller is-start" data-neo-tab-panel="{{ $panel }}" @if($panel !== 'punishments') hidden @endif>
                    <div class="es__cards-wrapper">
                        @foreach($feed as $item)
                            <article class="es__card">
                                <a class="es__card-name" href="{{ route('profile') }}">
                                    <span class="es__card-avatar neo3-avatar">{{ strtoupper(substr($item['name'], 0, 2)) }}</span>
                                    <span>{{ $item['name'] }}</span>
                                    <span class="es__card-type type-{{ $item['type'] }}">@svg($item['icon'])</span>
                                </a>
                                <div class="es__card-info">
                                    <span class="es__card-info-item reason">{{ $item['text'] }}</span>
                                    <span class="es__card-info-item time">@svg('clock') {{ $item['time'] }}</span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
