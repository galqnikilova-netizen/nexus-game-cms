<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsPost extends Model
{
    protected $fillable = ['author_id','title','slug','excerpt','content','image_path','category','is_published','is_featured','published_at'];
    protected function casts(): array { return ['is_published'=>'boolean','is_featured'=>'boolean','published_at'=>'datetime']; }
    public function author(): BelongsTo { return $this->belongsTo(User::class, 'author_id'); }
    public function scopePublished(Builder $query): Builder { return $query->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now()); }
    public function imageUrl(): ?string { return $this->image_path ? asset('storage/'.$this->image_path) : null; }
    public function getRouteKeyName(): string { return 'slug'; }
}
