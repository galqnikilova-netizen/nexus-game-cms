<?php

namespace App\Console\Commands;

use App\Models\GameServer;
use Illuminate\Console\Command;
use Throwable;
use xPaw\SourceQuery\SourceQuery;

class QueryGameServers extends Command
{
    protected $signature = 'nexus:query-servers {--id=}';
    protected $description = 'Refresh live data for visible Source and GoldSrc servers';

    public function handle(): int
    {
        $servers = GameServer::query()->where('is_visible', true)->when($this->option('id'), fn ($q,$id) => $q->whereKey($id))->get();
        foreach ($servers as $server) $this->query($server);
        $this->info("Refreshed {$servers->count()} server(s).");
        return self::SUCCESS;
    }

    private function query(GameServer $server): void
    {
        if (! in_array($server->game, ['cs2','cs16'], true)) return;
        $query = new SourceQuery(); $started = hrtime(true);
        try {
            $engine = $server->game === 'cs16' ? SourceQuery::GOLDSOURCE : SourceQuery::SOURCE;
            $query->Connect($server->host, $server->query_port ?: $server->port, 2, $engine);
            $info = $query->GetInfo();
            $server->update(['status'=>'online','players_online'=>(int)($info['Players']??0),'players_max'=>(int)($info['MaxPlayers']??0),'current_map'=>(string)($info['Map']??''),'latency_ms'=>(int)round((hrtime(true)-$started)/1_000_000),'last_query_at'=>now(),'last_error'=>null]);
        } catch (Throwable $e) {
            $server->update(['status'=>'offline','players_online'=>0,'last_query_at'=>now(),'last_error'=>mb_substr($e->getMessage(),0,500)]);
        } finally { $query->Disconnect(); }
    }
}

