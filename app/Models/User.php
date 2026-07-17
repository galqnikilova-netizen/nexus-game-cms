<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'locale',
        'role_id',
        'status',
        'steam_id',
        'avatar_url',
        'profile_url',
        'last_login_at',
        'balance',
    ];

    public function isAdmin(): bool
    {
        return in_array($this->role, ['owner', 'admin'], true);
    }

    public function nexusRole(): BelongsTo { return $this->belongsTo(Role::class, 'role_id'); }
    public function playerStats(): HasMany { return $this->hasMany(PlayerStat::class); }
    public function storeOrders(): HasMany { return $this->hasMany(StoreOrder::class); }
    public function balanceTransactions(): HasMany { return $this->hasMany(BalanceTransaction::class); }
    public function canNexus(string $permission): bool { return $this->role === 'owner' || $this->nexusRole?->allows($permission) === true; }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'balance' => 'decimal:2',
        ];
    }
}
