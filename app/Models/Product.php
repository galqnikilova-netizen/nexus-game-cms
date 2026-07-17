<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'type', 'description', 'price', 'duration_days', 'is_active', 'sort_order'];
    protected function casts(): array { return ['price' => 'decimal:2', 'duration_days' => 'integer', 'is_active' => 'boolean', 'sort_order' => 'integer']; }
}
