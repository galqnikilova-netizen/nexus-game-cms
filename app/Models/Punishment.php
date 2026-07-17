<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Punishment extends Model
{
    use HasFactory;

    protected $fillable = ['player_name', 'steam_id', 'server_id', 'admin_name', 'type', 'reason', 'duration_minutes', 'expires_at', 'status'];
    protected function casts(): array { return ['duration_minutes' => 'integer', 'expires_at' => 'datetime']; }
}
