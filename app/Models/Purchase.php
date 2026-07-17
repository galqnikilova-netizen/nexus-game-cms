<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'amount', 'currency', 'status', 'provider', 'provider_reference', 'activated_at'];
    protected function casts(): array { return ['amount' => 'decimal:2', 'activated_at' => 'datetime']; }
}
