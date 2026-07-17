@extends('layouts.app')
@section('title', 'Магазин — NEXUS')
@section('content')
<section class="store-hero"><div><span class="eyebrow">NEXUS MARKET</span><h1>Подобри играта си.</h1><p>Привилегии, баланс и персонализация с моментално активиране.</p><div><span>@svg('shield') Сигурно плащане</span><span>@svg('bolt') Моментална доставка</span></div></div><div class="coin-orbit"><span class="coin coin-one">N</span><span class="coin coin-two">N</span><span class="coin coin-three">N</span><strong>+500<small>NEXUS COINS</small></strong></div></section>
<div class="store-toolbar"><div class="segmented"><button class="is-active">Всички</button><button>VIP</button><button>Admin</button><button>Баланс</button></div><div class="select-shell"><select><option>Сортиране: Препоръчани</option><option>Цена: ниска към висока</option></select></div></div>
<section class="product-grid">
@foreach($products as $product)
<article class="product-card {{ $product['popular'] ? 'is-popular' : '' }}">@if($product['popular'])<span class="popular-ribbon">НАЙ-ПОПУЛЯРНО</span>@endif<div class="product-icon">@svg($product['type']==='BALANCE' ? 'bolt' : 'shield')</div><span class="product-type">{{ $product['type'] }}</span><h2>{{ $product['name'] }}</h2><div class="product-price"><strong>{{ $product['price'] }}</strong><span>лв.<small>/ {{ $product['period'] }}</small></span></div><ul>@foreach($product['features'] as $feature)<li>@svg('check') {{ $feature }}</li>@endforeach</ul><button class="button {{ $product['popular'] ? 'button-primary' : 'button-muted' }} width-full">Купи сега @svg('arrow')</button></article>
@endforeach
</section>
<section class="panel store-server-panel"><div><span class="eyebrow">ИЗБЕРИ СЪРВЪР</span><h2>Къде да се активира?</h2><p>Привилегията се активира автоматично след успешно плащане.</p></div><div class="server-choice-grid">@foreach($servers as $server)<label><input type="radio" name="server" {{ $loop->first ? 'checked' : '' }}><span><i></i><strong>{{ $server['name'] }}</strong><small>{{ $server['players'] }}/{{ $server['slots'] }} · {{ $server['map'] }}</small></span></label>@endforeach</div></section>
@endsection
