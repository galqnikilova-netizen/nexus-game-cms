<div class="row">
    <div class="col-md-12">
        <div class="cards__live-header"><h4 class="cards__live-title">Последни награди от картите</h4><div class="cards__live-filter"><button class="filter active">Всички</button><button class="filter">@svg('sparkles') Топ награди</button></div></div>
        <div class="cards__live-wrapper">
            @foreach($drops as $drop)
                <a href="{{ route('profile') }}" class="cards__live-block {{ $loop->iteration % 4 === 0 ? 'cards__live-rare' : '' }}">
                    <div class="cards__live-avatar"><span class="neo3-avatar">{{ strtoupper(substr($drop['name'],0,2)) }}</span><div class="cards__live-icon">@svg('ticket')</div><div class="cards__live-icon-shadow">@svg('ticket')</div></div>
                    <div class="cards__live-info"><div class="cards__live-username">{{ $drop['name'] }}</div><div class="cards__live-prise">{{ $drop['reward'] }}</div></div>
                </a>
            @endforeach
        </div>
    </div>
</div>
