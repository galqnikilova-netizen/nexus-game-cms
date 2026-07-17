<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subject', 'category', 'priority', 'status', 'last_reply_at'];
    protected function casts(): array { return ['last_reply_at' => 'datetime']; }
}
