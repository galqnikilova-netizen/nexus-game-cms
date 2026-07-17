<x-layouts.app title="{{ app()->getLocale()==='bg'?'Магазин':'Store' }} · NEXUS">
<div class="nx-page-pad"><div class="nx-shell">
    <div class="nx-section-head"><div><span class="nx-kicker">Premium services</span><h2>{{ app()->getLocale()==='bg'?'Магазин':'Store' }}</h2></div>@auth<button class="nx-top-action is-primary" data-balance-open>◈ {{ number_format((float)auth()->user()->balance,2) }} EUR · {{ app()->getLocale()==='bg'?'Зареди':'Top up' }}</button>@else<a class="nx-top-action is-primary" href="{{ route('login') }}">{{ app()->getLocale()==='bg'?'Влез за покупка':'Sign in to purchase' }}</a>@endauth</div>
    @if($errors->any())<div class="nx-card mb-3 border-rose-500/20 p-4 text-xs text-rose-300">{{ $errors->first() }}</div>@endif
    <div class="neo-store-layout">
        <main>
            <nav class="neo-store-tabs"><a class="{{ $category==='all'?'is-active':'' }}" href="{{ route('shop.index') }}">{{ app()->getLocale()==='bg'?'Всички':'All' }}</a>@foreach($categories as $name=>$total)<a class="{{ $category===$name?'is-active':'' }}" href="{{ route('shop.index',['category'=>$name]) }}">{{ strtoupper($name) }} <small>{{ $total }}</small></a>@endforeach</nav>
            <div class="neo-product-grid">
                @forelse($products as $product)
                    <article class="neo-product" style="--product-accent:{{ $product->accent }}">
                        @if($product->is_featured)<span class="neo-featured">Popular</span>@endif
                        <small>{{ strtoupper($product->category) }}</small><h3>{{ $product->name }}</h3><p>{{ $product->description }}</p>
                        <label>{{ app()->getLocale()==='bg'?'Период':'Duration' }}<strong>{{ $product->duration_days?round($product->duration_days/30).' month':'Permanent' }}</strong></label>
                        <ul>@foreach($product->features??[] as $feature)<li>✓ {{ $feature }}</li>@endforeach</ul>
                        <footer><b>{{ number_format((float)$product->price,2) }}<small> EUR</small></b>
                            @auth<button type="button" data-product-open data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}">{{ app()->getLocale()==='bg'?'Купи':'Buy now' }}</button>@else<a href="{{ route('login') }}">Sign in</a>@endauth
                        </footer>
                    </article>
                @empty<div class="nx-card col-span-full p-16 text-center text-xs text-slate-500">No products in this category.</div>@endforelse
            </div>
        </main>
        <aside class="neo-cart-panel nx-card">
            <header><span class="nx-kicker">Your account</span><h3>{{ app()->getLocale()==='bg'?'Покупки и баланс':'Purchases & balance' }}</h3></header>
            @auth<div class="neo-balance"><small>AVAILABLE BALANCE</small><strong>{{ number_format((float)auth()->user()->balance,2) }} <span>EUR</span></strong><button data-balance-open>{{ app()->getLocale()==='bg'?'Зареди баланс':'Top up balance' }} →</button></div><div class="neo-orders"><small>RECENT ORDERS</small>@forelse($orders as $order)<div><span><b>{{ $order->product->name }}</b><small>{{ $order->created_at->format('d.m.Y H:i') }}</small></span><strong>{{ $order->amount }} €</strong></div>@empty<p>{{ app()->getLocale()==='bg'?'Все още няма покупки.':'No purchases yet.' }}</p>@endforelse</div>@else<div class="p-5 text-center text-xs text-slate-500"><a class="nx-button w-full" href="{{ route('login') }}">Steam sign in</a></div>@endauth
        </aside>
    </div>
</div></div>

@auth
<div class="neo-modal" id="balance-modal" aria-hidden="true"><button class="neo-modal-backdrop" data-modal-close></button><section><button class="neo-modal-close" data-modal-close>×</button><span class="nx-kicker">Account balance</span><h2>{{ app()->getLocale()==='bg'?'Зареждане на баланс':'Top up balance' }}</h2><form method="POST" action="{{ route('balance.store') }}">@csrf<label>{{ app()->getLocale()==='bg'?'Метод на плащане':'Payment method' }}</label><div class="neo-payment-options">@foreach(['stripe'=>'Card','paypal'=>'PayPal','epay'=>'ePay','manual'=>'Manual'] as $key=>$name)<label><input type="radio" name="provider" value="{{ $key }}" @checked($loop->first)><span>{{ $name }}</span></label>@endforeach</div><label>{{ app()->getLocale()==='bg'?'Сума':'Amount' }}</label><div class="neo-amounts">@foreach([5,10,25,50,100] as $amount)<button type="button" data-amount="{{ $amount }}">{{ $amount }} €</button>@endforeach</div><input class="nx-input" id="balance-amount" type="number" name="amount" min="5" max="500" step="0.01" value="10"><button class="nx-button mt-4 w-full">{{ app()->getLocale()==='bg'?'Продължи към плащане':'Continue to payment' }}</button></form></section></div>
<div class="neo-modal" id="product-modal" aria-hidden="true"><button class="neo-modal-backdrop" data-modal-close></button><section><button class="neo-modal-close" data-modal-close>×</button><span class="nx-kicker">Confirm purchase</span><h2 id="purchase-title">Product</h2><p class="mt-2 text-xs text-slate-500">{{ app()->getLocale()==='bg'?'Избери сървър и потвърди покупката.':'Select a server and confirm your purchase.' }}</p><form id="purchase-form" method="POST" action="">@csrf<label>{{ app()->getLocale()==='bg'?'Сървър':'Server' }}</label><select class="nx-input" name="server_id"><option value="">Global / all servers</option>@foreach($servers as $server)<option value="{{ $server->id }}">{{ $server->name }}</option>@endforeach</select><div class="neo-purchase-total"><span>Total</span><strong id="purchase-price">0.00 EUR</strong></div><button class="nx-button w-full">{{ app()->getLocale()==='bg'?'Потвърди покупката':'Confirm purchase' }}</button></form></section></div>
@endauth
</x-layouts.app>
