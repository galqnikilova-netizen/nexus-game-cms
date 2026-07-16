<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model;
class Setting extends Model { public $incrementing=false; protected $primaryKey='key'; protected $keyType='string'; protected $fillable=['key','value','type','is_public']; protected function casts(): array{return ['is_public'=>'boolean'];} public static function valueOf(string $key,mixed $default=null):mixed{return static::query()->whereKey($key)->value('value')??$default;} }
