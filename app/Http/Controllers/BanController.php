<?php
namespace App\Http\Controllers; use App\Services\CsBansService; use Illuminate\Http\Request; use Illuminate\View\View;
class BanController extends Controller { public function index(Request $request,CsBansService $service):View{$search=trim((string)$request->query('q'));return view('bans.index',['bans'=>$service->bans($search?:null),'stats'=>$service->stats(),'enabled'=>$service->enabled(),'search'=>$search]);} }
