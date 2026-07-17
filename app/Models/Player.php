<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'server_id', 'steam_id', 'nickname', 'rating', 'kills', 'deaths', 'wins', 'playtime_minutes', 'last_seen_at'];
    protected function casts(): array { return ['rating' => 'integer', 'kills' => 'integer', 'deaths' => 'integer', 'wins' => 'integer', 'playtime_minutes' => 'integer', 'last_seen_at' => 'datetime']; }
}
