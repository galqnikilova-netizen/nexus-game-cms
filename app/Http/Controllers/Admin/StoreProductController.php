<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\GameServer;
use App\Models\StoreOrder;
use App\Models\StoreProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
class StoreProductController extends Controller {
    public function index():View{return view('admin.store.index',['products'=>StoreProduct::withCount('orders')->orderBy('sort_order')->get(),'orders'=>StoreOrder::with(['user','product','server'])->latest()->limit(50)->get()]);}
    public function create():View{return view('admin.store.form',['product'=>new StoreProduct(),'servers'=>GameServer::orderBy('sort_order')->get()]);}
    public function store(Request $request):RedirectResponse{$product=StoreProduct::create($this->validated($request));return redirect()->route('admin.products.edit',$product)->with('success','Продуктът е създаден.');}
    public function edit(StoreProduct $product):View{return view('admin.store.form',compact('product')+['servers'=>GameServer::orderBy('sort_order')->get()]);}
    public function update(Request $request,StoreProduct $product):RedirectResponse{$product->update($this->validated($request,$product));return back()->with('success','Продуктът е обновен.');}
    public function destroy(StoreProduct $product):RedirectResponse{if($product->orders()->exists()){$product->update(['is_active'=>false]);return back()->with('success','Продуктът има поръчки и беше архивиран.');}$product->delete();return back()->with('success','Продуктът е изтрит.');}
    private function validated(Request $request,?StoreProduct $product=null):array{$data=$request->validate(['name'=>['required','string','max:120'],'slug'=>['nullable','string','max:120',Rule::unique('store_products','slug')->ignore($product)],'category'=>['required','string','max:40'],'description'=>['nullable','string','max:2000'],'features_text'=>['nullable','string','max:3000'],'price'=>['required','numeric','min:0','max:99999'],'duration_days'=>['nullable','integer','min:1','max:3650'],'accent'=>['required','regex:/^#[0-9a-fA-F]{6}$/'],'game_server_id'=>['nullable','exists:game_servers,id'],'sort_order'=>['required','integer','min:0'],'is_featured'=>['nullable','boolean'],'is_active'=>['nullable','boolean']]);$data['slug']=$data['slug']?:Str::slug($data['name']);$data['features']=collect(preg_split('/\R/',$data['features_text']??''))->map(fn($v)=>trim($v))->filter()->values()->all();unset($data['features_text']);$data['is_featured']=$request->boolean('is_featured');$data['is_active']=$request->boolean('is_active');return $data;}
}
