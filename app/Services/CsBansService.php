<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class CsBansService
{
    public function enabled(): bool { return (bool) config('csbans.enabled'); }

    public function table(string $name): string
    {
        $prefix = (string) config('csbans.prefix', 'amx');
        if (! preg_match('/^[a-zA-Z0-9_]+$/', $prefix)) throw new RuntimeException('Invalid CSBans table prefix.');
        return $prefix.'_'.$name;
    }

    public function bans(?string $search = null, int $perPage = 25): LengthAwarePaginatorContract
    {
        if (! $this->enabled()) return new LengthAwarePaginator([], 0, $perPage, 1, ['path' => request()->url()]);
        $query = DB::connection(config('csbans.connection'))->table($this->table('bans'))
            ->select(['bid', 'player_ip', 'player_id', 'player_nick', 'admin_nick', 'ban_reason', 'ban_created', 'ban_length', 'server_name', 'expired'])->orderByDesc('ban_created');
        if ($search) {
            $escaped = addcslashes($search, '%_');
            $query->where(fn ($item) => $item->where('player_nick', 'like', '%'.$escaped.'%')->orWhere('player_id', 'like', '%'.$escaped.'%')->orWhere('player_ip', 'like', '%'.$escaped.'%'));
        }
        return $query->paginate($perPage)->through(fn ($ban) => $this->present($ban));
    }

    public function stats(): array
    {
        if (! $this->enabled()) return ['total' => 0, 'active' => 0, 'permanent' => 0];
        $connection = DB::connection(config('csbans.connection'));
        $table = $this->table('bans');
        return Cache::remember('csbans.stats', (int) config('csbans.cache_seconds', 60), fn () => [
            'total' => $connection->table($table)->count(),
            'active' => $connection->table($table)->where('expired', 0)->where('ban_length', '>=', 0)->where(fn ($query) => $query->where('ban_length', 0)->orWhereRaw('ban_created + (ban_length * 60) > UNIX_TIMESTAMP()'))->count(),
            'permanent' => $connection->table($table)->where('ban_length', 0)->where('expired', 0)->count(),
        ]);
    }

    public function present(object $ban): object
    {
        $length = (int) $ban->ban_length; $created = (int) $ban->ban_created;
        $ban->is_permanent = $length === 0;
        $ban->is_active = $length >= 0 && (int) $ban->expired === 0 && ($ban->is_permanent || $created + ($length * 60) > time());
        $ban->created_at = Carbon::createFromTimestamp($created);
        $ban->expires_at = $length > 0 ? Carbon::createFromTimestamp($created + ($length * 60)) : null;
        $ban->safe_reason = Str::limit(strip_tags((string) $ban->ban_reason), 100);
        return $ban;
    }
}
