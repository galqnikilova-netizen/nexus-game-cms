<?php
namespace App\Http\Controllers;
use App\Models\BalanceTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class BalanceController extends Controller {
    public function store(Request $request):RedirectResponse {
        $data=$request->validate(['amount'=>['required','numeric','min:5','max:500'],'provider'=>['required','in:stripe,paypal,epay,manual']]);
        BalanceTransaction::create(['uuid'=>(string)Str::uuid(),'user_id'=>$request->user()->id,'direction'=>'credit','amount'=>$data['amount'],'provider'=>$data['provider'],'status'=>'pending','reference'=>'NX-'.strtoupper(Str::random(10))]);
        return back()->with('success','Заявката за плащане е създадена. Ще бъде активирана след свързване на платежния доставчик.');
    }
}
