<?php
namespace App\Http\Controllers; use App\Models\User; use Illuminate\View\View;
class ProfileController extends Controller { public function show(User $user):View{$user->load(['playerStats.server','storeOrders.product']);$summary=['score'=>$user->playerStats->sum('score'),'kills'=>$user->playerStats->sum('kills'),'deaths'=>$user->playerStats->sum('deaths'),'headshots'=>$user->playerStats->sum('headshots'),'playtime'=>$user->playerStats->sum('playtime_minutes')];return view('profile.show',compact('user','summary'));} }
