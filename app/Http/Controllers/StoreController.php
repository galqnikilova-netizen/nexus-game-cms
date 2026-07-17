<?php
namespace App\Http\Controllers;
use App\Models\BalanceTransaction;
use App\Models\GameServer;
use App\Models\StoreOrder;
use App\Models\StoreProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;
class StoreController extends Controller {
    public function index(Request $request):View {
        $category=$request->query('category','all');
        $products=StoreProduct::query()->where('is_active',true)->when($category!=='all',fn($q)=>$q->where('category',$category))->orderBy('sort_order')->get();
        $servers=GameServer::query()->where('is_visible',true)->orderBy('sort_order')->get();
        $categories=StoreProduct::query()->where('is_active',true)->selectRaw('category, count(*) as total')->groupBy('category')->pluck('total','category');
        $orders=auth()->check()?auth()->user()->storeOrders()->with('product')->latest()->limit(5)->get():collect();
        return view('shop',compact('products','servers','categories','category','orders'));
    }
    public function purchase(Request $request,StoreProduct $product):RedirectResponse {
        abort_unless($product->is_active,404);
        $data=$request->validate(['server_id'=>['nullable','exists:game_servers,id']]);
        try { DB::transaction(function()use($request,$product,$data):void{
            $user=$request->user()->newQuery()->lockForUpdate()->findOrFail($request->user()->id);
            if((float)$user->balance<(float)$product->price)throw new RuntimeException('INSUFFICIENT_BALANCE');
            $user->decrement('balance',$product->price); $user->refresh();
            $order=StoreOrder::create(['uuid'=>(string)Str::uuid(),'user_id'=>$user->id,'store_product_id'=>$product->id,'game_server_id'=>$data['server_id']??$product->game_server_id,'amount'=>$product->price,'status'=>'completed','completed_at'=>now()]);
            BalanceTransaction::create(['uuid'=>(string)Str::uuid(),'user_id'=>$user->id,'direction'=>'debit','amount'=>$product->price,'balance_after'=>$user->balance,'provider'=>'store','status'=>'completed','reference'=>$order->uuid]);
        }); } catch(RuntimeException $e){ if($e->getMessage()==='INSUFFICIENT_BALANCE')return back()->withErrors(['purchase'=>'Недостатъчен баланс. Зареди профила си и опитай отново.']); throw $e; }
        return back()->with('success','Покупката е завършена успешно.');
    }
}
