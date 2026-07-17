<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class StoreOrder extends Model {
    protected $fillable=['uuid','user_id','store_product_id','game_server_id','amount','status','metadata','completed_at'];
    protected function casts():array{return ['amount'=>'decimal:2','metadata'=>'array','completed_at'=>'datetime'];}
    public function user():BelongsTo{return $this->belongsTo(User::class);}
    public function product():BelongsTo{return $this->belongsTo(StoreProduct::class,'store_product_id');}
    public function server():BelongsTo{return $this->belongsTo(GameServer::class,'game_server_id');}
}
