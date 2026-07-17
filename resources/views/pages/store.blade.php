@extends('layouts.neo3')
@section('title', 'Магазин — NEXUS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/neo3-store.css') }}">
@endpush

@section('content')
@php
    $categoryMap = ['ADMIN'=>1, 'VIP'=>2, 'VIP + ADMIN'=>3, 'BALANCE'=>5];
    $categoryNames = [0=>'Всички', 1=>'Админ', 2=>'VIP', 3=>'VIP + админ', 5=>'VIP функция'];
    $colors = ['#7e9dff', '#9b7eff', '#64ce82', '#f4ca80'];
    $periods = [
        0 => [['label'=>'30 дни','price'=>19.99],['label'=>'90 дни','price'=>49.99],['label'=>'1 година','price'=>149.99]],
        1 => [['label'=>'30 дни','price'=>8.99],['label'=>'90 дни','price'=>22.99],['label'=>'1 година','price'=>79.99]],
        2 => [['label'=>'14 дни','price'=>14.99],['label'=>'30 дни','price'=>24.99],['label'=>'90 дни','price'=>64.99]],
        3 => [['label'=>'500 coins','price'=>5.00],['label'=>'1 200 coins','price'=>10.00],['label'=>'3 000 coins','price'=>20.00]],
    ];
@endphp

<div class="row shop_bk row_reverse neo3-store-page" data-neo3-store>
    <div class="col-md-9">
        <div class="neo3-store-toolbar">
            <div>
                <span class="neo3-store-kicker">NEXUS MARKET</span>
                <h1>Магазин за привилегии</h1>
                <p>Избери продукт, период и сървър. След успешно плащане активирането ще бъде автоматично.</p>
            </div>
            <button class="neo3-store-cart" type="button" data-store-open-cart>
                @svg('store')
                <span>Кошница</span>
                <b data-store-cart-count>0</b>
            </button>
        </div>

        <div class="shop_wrapper_product">
            @foreach($products as $product)
            @php
                $productId = $loop->iteration;
                $category = $categoryMap[$product['type']] ?? 0;
                $serverId = (($loop->index) % max(count($servers), 1)) + 1;
                $color = $colors[$loop->index % count($colors)];
                $options = $periods[$loop->index] ?? [['label'=>$product['period'],'price'=>(float)$product['price']]];
                $firstOption = $options[0];
            @endphp
            <div class="shop_product_wrapper shop_product_server_{{ $serverId }} shop_product_cat_{{ $category }} shop_card_wrapper"
                 data-store-card data-product-id="{{ $productId }}" data-category="{{ $category }}" data-server="{{ $serverId }}" data-price="{{ $firstOption['price'] }}" style="--product-color:{{ $color }}">
                <div class="shop_product">
                    <div class="header__badges">
                        @if($product['popular'])<div class="shop_badge">Най-популярно</div>@endif
                        <div class="shop_badge neo3-store-type">{{ $product['type'] }}</div>
                    </div>
                    <div class="shop_header neo3-store-header">
                        <div class="shop_product_img neo3-store-art">@svg($product['type']==='BALANCE' ? 'bolt' : 'shield')</div>
                        <div class="shop_product_title"><p class="shop_product_gradient_text">{{ $product['name'] }}</p></div>
                    </div>

                    <div class="shop_product_select_title" data-store-select>
                        <input type="hidden" data-store-period-value value="0">
                        <div class="shop_product_select_title_text"><span data-store-period-label>{{ $firstOption['label'] }}</span> - <span class="neo3-store-accent" data-store-price-label>{{ number_format($firstOption['price'], 2) }} лв.</span></div>
                        <div class="shop_product_select_button neo3-store-accent">@svg('arrow')</div>
                        <div class="shop_product_select no-scrollbar" data-store-options hidden>
                            @foreach($options as $option)
                            <button class="shop_product_option" type="button" data-store-option data-label="{{ $option['label'] }}" data-price="{{ $option['price'] }}">
                                <span class="shop_price_title">{{ $option['label'] }} - </span><span class="shop_price_title_value neo3-store-accent">{{ number_format($option['price'], 2) }} лв.</span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="shop_product_description">Предимства <button class="shop_product_button_info" type="button" data-store-details>Виж всички</button></div>
                    <div class="shop_product_properties scroll">
                        @foreach(array_slice($product['features'],0,4) as $feature)
                        <div class="shop_product_property"><div class="shop_product_property_icon neo3-store-accent">@svg('check')</div><div class="shop_product_property_title">{{ $feature }}</div></div>
                        @endforeach
                    </div>
                    <div class="shop_flex_row">
                        <div class="shop_buy_price"><div class="shop_product_description_price"><div class="shop_product_price"><span class="shop_product_price_count" data-store-footer-price>{{ number_format($firstOption['price'],2) }}</span><span class="shop_product_price_value">лв.</span></div></div></div>
                        <button class="shop_product_button" type="button" data-store-add data-product-name="{{ $product['name'] }}">В кошницата</button>
                    </div>
                </div>
                <template data-store-features>@foreach($product['features'] as $feature)<li>{{ $feature }}</li>@endforeach</template>
            </div>
            @endforeach
        </div>
        <div class="neo3-store-empty" data-store-empty hidden>Няма продукти за избраните филтри.</div>
    </div>

    <div class="col-md-3 shop_servers_wrap_area sticky-block">
        <span class="store__filter-title">Избери категория</span>
        <div class="categories" data-store-categories>
            @foreach($categoryNames as $id=>$name)
            <button class="filter filter-category categories_btn {{ $id===0 ? 'active' : '' }}" type="button" data-category="{{ $id }}">@svg($id===0 ? 'filter' : 'sparkles') {{ $name }}</button>
            @endforeach
        </div>
        <span class="store__filter-title">Сортирай по цена</span>
        <div class="filter__by-price" data-store-sort>
            <button class="filter flex-1 active" type="button" data-sort="default">По подразбиране</button>
            <button class="filter flex-1" type="button" data-sort="low">Евтини</button>
            <button class="filter flex-1" type="button" data-sort="high">Скъпи</button>
        </div>
        <hr>
        <div class="choosing_text">Продукти за: <span data-store-server-name>{{ $servers[0]['name'] }}</span></div>
        <div class="neo3-store-servers" data-store-servers>
            <button type="button" data-server="0" class="width-100 shop_server shop_button_servers active">Всички сървъри</button>
            @foreach($servers as $server)
            <button type="button" data-server="{{ $loop->iteration }}" class="width-100 shop_server shop_button_servers"><span><b>{{ $server['mode'] }}</b><small>{{ $server['players'] }}/{{ $server['slots'] }} · {{ $server['map'] }}</small></span></button>
            @endforeach
        </div>
        <div class="neo3-store-security"><span>@svg('shield')</span><div><strong>Сигурно плащане</strong><small>Gateway интеграцията ще се свърже в backend етапа.</small></div></div>
    </div>
</div>

<div class="shop_black_screen" data-store-overlay hidden></div>
<div class="neo3-store-checkout" data-store-checkout hidden role="dialog" aria-modal="true" aria-label="Кошница">
    <div class="neo3-store-checkout-head"><div><span class="neo3-store-kicker">NEXUS CHECKOUT</span><h2>Твоята кошница</h2></div><button type="button" data-store-close>@svg('x')</button></div>
    <div class="neo3-store-cart-list" data-store-cart-list></div>
    <div class="neo3-store-cart-empty" data-store-cart-empty>Кошницата е празна.</div>
    <div class="neo3-store-checkout-form">
        <div class="inputs-inline"><label for="storeSteam">Steam ID</label><input id="storeSteam" placeholder="STEAM_1:1:390... / 7656119..."></div>
        <div class="inputs-inline"><label for="storeGateway">Метод на плащане</label><select id="storeGateway"><option>Банкова карта</option><option>PayPal</option><option>NEXUS баланс</option></select></div>
        <label class="neo3-store-agreement"><input type="checkbox" data-store-agreement> Съгласен съм с условията за покупка</label>
    </div>
    <div class="neo3-store-checkout-total"><span>Общо</span><strong data-store-total>0.00 лв.</strong></div>
    <button class="button-pay width-100" type="button" data-store-pay disabled>Продължи към плащане</button>
</div>

<div class="properties_table neo3-store-details" data-store-details-panel hidden>
    <button class="button close_properties_table" type="button" data-store-details-close>@svg('arrow')</button>
    <div class="shop_product_description">Всички предимства</div>
    <div class="props no-scrollbar"><ul data-store-details-list></ul></div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/neo3-store.js') }}" defer></script>
@endpush
