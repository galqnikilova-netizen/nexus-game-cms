<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('game_servers', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('game', 32)->index();
            $table->string('host');
            $table->unsignedSmallInteger('port');
            $table->unsignedSmallInteger('query_port')->nullable();
            $table->text('rcon_password')->nullable();
            $table->enum('status', ['online', 'offline', 'unknown'])->default('unknown')->index();
            $table->unsignedSmallInteger('players_online')->default(0);
            $table->unsignedSmallInteger('players_max')->default(0);
            $table->string('current_map')->nullable();
            $table->unsignedInteger('latency_ms')->nullable();
            $table->timestamp('last_query_at')->nullable();
            $table->string('last_error', 500)->nullable();
            $table->boolean('is_visible')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['host', 'port']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_servers');
    }
};
