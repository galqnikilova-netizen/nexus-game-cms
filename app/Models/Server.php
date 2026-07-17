<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'game', 'mode', 'map', 'players', 'max_players', 'status', 'query_port'];
    protected function casts(): array { return ['players' => 'integer', 'max_players' => 'integer']; }
}
