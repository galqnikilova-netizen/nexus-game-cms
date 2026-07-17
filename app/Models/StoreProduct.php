<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class StoreProduct extends Model {
    protected $fillable=['game_server_id','slug','name','category','description','features','price','duration_days','accent','is_featured','is_active','sort_order'];
    protected function casts():array{return ['features'=>'array','price'=>'decimal:2','is_featured'=>'boolean','is_active'=>'boolean'];}
    public function server():BelongsTo{return $this->belongsTo(GameServer::class,'game_server_id');}
    public function orders():HasMany{return $this->hasMany(StoreOrder::class);}
}
