<x-layouts.app title="{{ $nexusAppearance['site_name'] }}">
@php
    $totalPlayers = $servers->sum('players_online');
    $totalSlots = max(1, $servers->sum('players_max'));
    $onlineServers = $servers->where('status', 'online')->count();
@endphp

<div class="neo3-native-home">
    <div class="row" id="rowModsServers">
        <div class="col-md-12">
            <div class="mods__wrapper mods__row-5 mods__centered mods-ready">
                @forelse($servers as $server)
                    <article class="mods__card" data-mod="{{ strtoupper($server->game) }}">
                        <div class="mods__servers-counter">
                            <x-nx-icon name="servers" />
                            <span class="mods__servers-count">1</span>
                        </div>
                        <div class="mods__info">
                            <div class="mods__title">{{ strtoupper($server->game) }}</div>
                            <div class="mods__online">
                                <i class="ring-online"></i>
                                <span>{{ $server->players_online }}</span>
                                {{ app()->getLocale()==='bg' ? 'в игра' : 'in game' }}
                            </div>
                        </div>
                        <img class="mods__first-image" src="{{ $server->mapArtwork() }}" alt="{{ $server->current_map }}">
                        <div class="mods__shadow"></div>
                        <div class="mod__bottom-info">
                            <div class="mod__desc-text">{{ $server->name }}</div>
                            <a class="mods__button-search active filter" href="steam://connect/{{ $server->host }}:{{ $server->port }}">
                                <span>▶</span>
                                {{ app()->getLocale()==='bg' ? 'Бърза игра' : 'Quick play' }}
                            </a>
                        </div>
                    </article>
                @empty
                    @foreach(['PUBLIC','AWP','RETAKE','DEATHMATCH'] as $mode)
                        <article class="mods__card">
                            <div class="mods__servers-counter"><x-nx-icon name="servers"/><span class="mods__servers-count">0</span></div>
                            <div class="mods__info"><div class="mods__title">{{ $mode }}</div><div class="mods__online"><i class="ring-online"></i>0 {{ app()->getLocale()==='bg'?'в игра':'in game' }}</div></div>
                            <img class="mods__first-image" src="{{ asset('images/maps/default.svg') }}" alt="">
                            <div class="mods__shadow"></div>
                            <div class="mod__bottom-info"><div class="mod__desc-text">{{ app()->getLocale()==='bg'?'Очаква настройка на сървър':'Awaiting server setup' }}</div></div>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="info-block__wrapper-global">
                <div class="info-block__wrapper">
                    <a href="{{ route('community.index') }}" class="info-block__card" style="background-image:linear-gradient(to right,#2aabee,#135c7e)">
                        <h3 class="info-block__title">{{ app()->getLocale()==='bg'?'Присъедини се към Telegram':'Join our Telegram' }}</h3>
                        <span class="info-block__description">{{ app()->getLocale()==='bg'?'Новини и директна връзка с екипа':'News and direct team support' }}</span>
                        <img class="info-block__image" src="{{ asset('vendor/neo3/app/modules/module_block_main_advert/assets/img/telegram icon.png') }}" alt="">
                    </a>
                    <a href="{{ route('news.index') }}" class="info-block__card" style="background-image:linear-gradient(to right,#35191c,#7e2028)">
                        <h3 class="info-block__title">{{ app()->getLocale()==='bg'?'Последни новини':'Latest news' }}</h3>
                        <span class="info-block__description">{{ app()->getLocale()==='bg'?'Следи развитието на общността':'Follow the community updates' }}</span>
                        <img class="info-block__image" src="{{ asset('vendor/neo3/app/modules/module_block_main_advert/assets/img/youtube icon.png') }}" alt="">
                    </a>
                    <a href="{{ route('shop.index') }}" class="info-block__card" style="background-image:linear-gradient(to right,#171717,#292827)">
                        <h3 class="info-block__title">{{ app()->getLocale()==='bg'?'Премиум услуги':'Premium services' }}</h3>
                        <span class="info-block__description">{{ app()->getLocale()==='bg'?'VIP и специални възможности':'VIP and special features' }}</span>
                        <img class="info-block__image" src="{{ asset('vendor/neo3/app/modules/module_block_main_advert/assets/img/tiktok icon.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row neo3-news-row">
        <div class="col-md-9">
            <div class="image-slider swiper neo3-news-slider">
                <div class="image-slider__wrapper swiper-wrapper">
                @forelse($posts->take(3) as $post)
                    <a class="image-slider__slide swiper-slide" href="{{ route('news.show',$post) }}">
                        <div class="image-slider__image">
                            <p>{{ $post->category }} · {{ $post->published_at->format('d.m.Y') }}</p>
                            <h3>{{ $post->title }}</h3>
                            <span class="swiper_btn">{{ app()->getLocale()==='bg'?'Прочети':'Read more' }} →</span>
                            @if($post->imageUrl())<img src="{{ $post->imageUrl() }}" alt="">@endif
                        </div>
                    </a>
                @empty
                    <div class="image-slider__slide"><div class="image-slider__image"><p>NEWS</p><h3>{{ app()->getLocale()==='bg'?'Очаквайте новини':'News coming soon' }}</h3></div></div>
                @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card lk-top__card">
                <div class="lk-top__wrapper">
                    <h4 class="lk-top__title"><x-nx-icon name="community"/><span>{{ app()->getLocale()==='bg'?'Мрежа в реално време':'Live network' }}</span></h4>
                    <div class="lk-top__buttons"><a class="filter lk-top__chips-btn active" href="{{ route('servers.index') }}">{{ app()->getLocale()==='bg'?'Сървъри':'Servers' }}</a><a class="filter lk-top__chips-btn" href="{{ route('leaderboard.index') }}">TOP</a></div>
                    <div class="lk-top__content-wrapper"><div class="lk-top__content neo3-network-list"><span>{{ app()->getLocale()==='bg'?'Онлайн сървъри':'Online servers' }} <b>{{ $onlineServers }}/{{ $servers->count() }}</b></span><span>{{ app()->getLocale()==='bg'?'Играчи онлайн':'Players online' }} <b>{{ $totalPlayers }}</b></span><span>{{ app()->getLocale()==='bg'?'Заетост':'Occupancy' }} <b>{{ round(($totalPlayers/$totalSlots)*100) }}%</b></span></div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row neo3-statistics-row">
        @foreach([
            [app()->getLocale()==='bg'?'Играчи онлайн':'Players online',$totalPlayers,'community'],
            [app()->getLocale()==='bg'?'Активни сървъри':'Active servers',$onlineServers,'servers'],
            [app()->getLocale()==='bg'?'Слотове':'Total slots',$servers->sum('players_max'),'dashboard'],
            [app()->getLocale()==='bg'?'Новини':'News',$posts->count(),'news'],
            [app()->getLocale()==='bg'?'Заетост':'Occupancy',round(($totalPlayers/$totalSlots)*100).'%', 'leaderboard'],
            [app()->getLocale()==='bg'?'Услуги':'Services','VIP','shop']
        ] as [$label,$value,$icon])
            <div class="col-md-2"><div class="statistics_container"><div class="statistics_name">{{ $label }}</div><div class="statistics_number">{{ $value }}</div><div class="statistics_icon"><x-nx-icon :name="$icon"/></div></div></div>
        @endforeach
    </div>
</div>
</x-layouts.app>
