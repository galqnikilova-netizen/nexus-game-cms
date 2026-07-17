<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PlayerStat extends Model {
    protected $fillable=['user_id','game_server_id','rank','score','kills','deaths','headshots','shots','hits','playtime_minutes','last_seen_at'];
    protected function casts():array{return ['last_seen_at'=>'datetime'];}
    public function user():BelongsTo{return $this->belongsTo(User::class);}
    public function server():BelongsTo{return $this->belongsTo(GameServer::class,'game_server_id');}
    public function kd():float{return $this->deaths>0?round($this->kills/$this->deaths,2):(float)$this->kills;}
    public function headshotRate():int{return $this->kills>0?(int)round(($this->headshots/$this->kills)*100):0;}
    public function accuracy():int{return $this->shots>0?(int)round(($this->hits/$this->shots)*100):0;}
}
