<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class BalanceTransaction extends Model {
    protected $fillable=['uuid','user_id','direction','amount','balance_after','provider','status','reference','metadata'];
    protected function casts():array{return ['amount'=>'decimal:2','balance_after'=>'decimal:2','metadata'=>'array'];}
    public function user():BelongsTo{return $this->belongsTo(User::class);}
}
