<div class="row">
    <div class="col-md-9">
        <div class="image-slider swiper">
            <div class="image-slider__wrapper swiper-wrapper">
                <div class="image-slider__slide swiper-slide"><div class="image-slider__image"><p>NEXUS ADMIN TEAM</p><h3>Стани част от проекта</h3><a class="swiper_btn" href="{{ route('tickets') }}">Кандидатствай @svg('arrow')</a></div></div>
            </div>
            <div class="swiper-buttons"><button class="swiper-button-prev" type="button"></button><button class="swiper-button-next" type="button"></button></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card lk-top__card">
            <div class="lk-top__wrapper">
                <h4 class="lk-top__title">@svg('help')<span>Топ поддръжници за</span></h4>
                <div class="lk-top__buttons"><button class="filter lk-top__chips-btn width-100 active">7 дни</button><button class="filter lk-top__chips-btn width-100">30 дни</button><button class="filter lk-top__chips-btn width-100">Всичко</button></div>
                <div class="lk-top__content-wrapper"><div class="lk-top__content neo3-top-list">
                    @foreach(array_slice($purchases, 0, 3) as $purchase)<div class="neo3-top-row"><b>{{ $loop->iteration }}</b><span class="neo3-avatar">{{ strtoupper(substr($purchase['name'],0,2)) }}</span><span>{{ $purchase['name'] }}</span><strong>{{ $purchase['price'] }}</strong></div>@endforeach
                </div></div>
            </div>
        </div>
    </div>
</div>
