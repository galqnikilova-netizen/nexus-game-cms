<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model;
class Module extends Model { protected $fillable=['slug','name','version','author','description','manifest','enabled','installed_at']; protected function casts(): array{return ['manifest'=>'array','enabled'=>'boolean','installed_at'=>'datetime'];} }
