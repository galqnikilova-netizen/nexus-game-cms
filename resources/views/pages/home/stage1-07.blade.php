<div class="row">
    @foreach($stats as $stat)
        <div class="col-md-2">
            <div class="statistics_container {{ $loop->iteration === 4 ? 'statistic__premium pulse_prem' : '' }}">
                <div class="statistics_name">{{ $stat['label'] }}</div><div class="statistics_number">{{ $stat['value'] }}</div><div class="statistics_icon">@svg($stat['icon'])</div>
            </div>
        </div>
    @endforeach
    <div class="col-md-2"><div class="statistics_container"><div class="statistics_name">Активни наказания</div><div class="statistics_number">284</div><div class="statistics_icon">@svg('gavel')</div></div></div>
    <div class="col-md-2"><div class="statistics_container"><div class="statistics_name">Отворени тикети</div><div class="statistics_number">12</div><div class="statistics_icon">@svg('ticket')</div></div></div>
</div>
