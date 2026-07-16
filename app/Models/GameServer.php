<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameServer extends Model
{
    protected $fillable = ['name', 'slug', 'game', 'host', 'port', 'query_port', 'rcon_password', 'is_visible', 'sort_order', 'status', 'players_online', 'players_max', 'current_map', 'latency_ms', 'last_query_at', 'last_error'];
    protected $hidden = ['rcon_password'];
    protected function casts(): array { return ['rcon_password' => 'encrypted', 'is_visible' => 'boolean', 'last_query_at' => 'datetime']; }
}
