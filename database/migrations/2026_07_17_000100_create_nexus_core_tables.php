<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('servers', function (Blueprint $table): void {
            $table->id(); $table->string('name'); $table->string('address')->unique(); $table->string('game')->default('CS2'); $table->string('mode')->nullable(); $table->string('map')->nullable(); $table->unsignedSmallInteger('players')->default(0); $table->unsignedSmallInteger('max_players')->default(0); $table->string('status')->default('offline'); $table->unsignedSmallInteger('query_port')->nullable(); $table->timestamps();
        });
        Schema::create('players', function (Blueprint $table): void {
            $table->id(); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $table->foreignId('server_id')->nullable()->constrained()->nullOnDelete(); $table->string('steam_id')->index(); $table->string('nickname'); $table->integer('rating')->default(1000); $table->unsignedInteger('kills')->default(0); $table->unsignedInteger('deaths')->default(0); $table->unsignedInteger('wins')->default(0); $table->unsignedInteger('playtime_minutes')->default(0); $table->timestamp('last_seen_at')->nullable(); $table->timestamps(); $table->unique(['server_id','steam_id']);
        });
        Schema::create('products', function (Blueprint $table): void {
            $table->id(); $table->string('name'); $table->string('slug')->unique(); $table->string('type'); $table->text('description')->nullable(); $table->decimal('price',12,2); $table->unsignedInteger('duration_days')->nullable(); $table->boolean('is_active')->default(true); $table->unsignedInteger('sort_order')->default(0); $table->timestamps();
        });
        Schema::create('purchases', function (Blueprint $table): void {
            $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete(); $table->decimal('amount',12,2); $table->char('currency',3)->default('BGN'); $table->string('status')->default('pending'); $table->string('provider')->nullable(); $table->string('provider_reference')->nullable()->index(); $table->timestamp('activated_at')->nullable(); $table->timestamps();
        });
        Schema::create('punishments', function (Blueprint $table): void {
            $table->id(); $table->string('player_name'); $table->string('steam_id')->nullable()->index(); $table->foreignId('server_id')->nullable()->constrained()->nullOnDelete(); $table->string('admin_name'); $table->string('type')->default('ban'); $table->string('reason'); $table->unsignedInteger('duration_minutes')->nullable(); $table->timestamp('expires_at')->nullable(); $table->string('status')->default('active'); $table->timestamps();
        });
        Schema::create('tickets', function (Blueprint $table): void {
            $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->string('subject'); $table->string('category')->default('general'); $table->string('priority')->default('normal'); $table->string('status')->default('open'); $table->timestamp('last_reply_at')->nullable(); $table->timestamps();
        });
        Schema::create('ticket_messages', function (Blueprint $table): void {
            $table->id(); $table->foreignId('ticket_id')->constrained()->cascadeOnDelete(); $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $table->longText('message'); $table->boolean('is_staff')->default(false); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ticket_messages'); Schema::dropIfExists('tickets'); Schema::dropIfExists('punishments'); Schema::dropIfExists('purchases'); Schema::dropIfExists('products'); Schema::dropIfExists('players'); Schema::dropIfExists('servers'); }
};
