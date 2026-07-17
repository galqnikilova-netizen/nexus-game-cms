<div class="table-responsive">
    <table class="table">
        <thead><tr><th>Карта</th><th>Резултат</th><th>Точки</th><th>K/D</th><th>Rating</th><th>Дата</th></tr></thead>
        <tbody>
        @foreach($recentMatches as $match)
            <tr><td><span class="neo3-profile-map"><i></i>{{ $match['map'] }}</span></td><td><span class="neo3-match-result {{ $match['result']==='Победа' ? 'win' : 'loss' }}">{{ $match['result'] }}</span></td><td><strong>{{ $match['score'] }}</strong></td><td class="leaderboard__table-grey-text">{{ $match['kd'] }}</td><td><span class="neo3-rating-change {{ str_starts_with($match['rating'],'-')?'down':'up' }}">{{ $match['rating'] }}</span></td><td class="leaderboard__table-grey-text">{{ $match['time'] }}</td></tr>
        @endforeach
        </tbody>
    </table>
</div>
