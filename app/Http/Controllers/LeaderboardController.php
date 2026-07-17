<?php
namespace App\Http\Controllers;
use App\Models\GameServer;
use App\Models\PlayerStat;
use Illuminate\Http\Request;
use Illuminate\View\View;
class LeaderboardController extends Controller {
    public function index(Request $request):View {
        $servers=GameServer::query()->where('is_visible',true)->orderBy('sort_order')->get();
        $serverId=$request->integer('server')?:null;
        $allowed=['score','kills','deaths','headshots','playtime_minutes','last_seen_at'];
        $sort=in_array($request->query('sort'),$allowed,true)?$request->query('sort'):'score';
        $stats=PlayerStat::query()->with(['user','server'])->when($serverId,fn($q)=>$q->where('game_server_id',$serverId))->orderByDesc($sort)->paginate(25)->withQueryString();
        return view('leaderboard.index',compact('servers','stats','serverId','sort'));
    }
}
