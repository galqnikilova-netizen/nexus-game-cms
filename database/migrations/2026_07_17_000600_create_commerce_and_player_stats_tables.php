<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('player_stats', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('game_server_id')->nullable()->constrained()->nullOnDelete();
            $table->string('rank', 64)->nullable();
            $table->integer('score')->default(0)->index();
            $table->unsignedInteger('kills')->default(0);
            $table->unsignedInteger('deaths')->default(0);
            $table->unsignedInteger('headshots')->default(0);
            $table->unsignedInteger('shots')->default(0);
            $table->unsignedInteger('hits')->default(0);
            $table->unsignedInteger('playtime_minutes')->default(0);
            $table->timestamp('last_seen_at')->nullable()->index();
            $table->timestamps();
            $table->unique(['user_id','game_server_id']);
        });

        Schema::create('store_products', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('game_server_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('category', 40)->index();
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->decimal('price', 12, 2);
            $table->unsignedSmallInteger('duration_days')->nullable();
            $table->string('accent', 16)->default('#7c86ff');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('store_orders', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_product_id')->constrained()->restrictOnDelete();
            $table->foreignId('game_server_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('status', 24)->default('completed')->index();
            $table->json('metadata')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('balance_transactions', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('direction', 12);
            $table->decimal('amount', 12, 2);
            $table->decimal('balance_after', 12, 2)->nullable();
            $table->string('provider', 32)->nullable();
            $table->string('status', 24)->default('pending')->index();
            $table->string('reference')->nullable()->index();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        $now = now();
        DB::table('store_products')->insert([
            ['slug'=>'lite','name'=>'Lite','category'=>'vip','description'=>'Начален пакет за активните играчи.','features'=>json_encode(['Reserved slot','Custom profile badge','Reset deaths']), 'price'=>5.99,'duration_days'=>30,'accent'=>'#f1f1ef','is_featured'=>false,'is_active'=>true,'sort_order'=>10,'created_at'=>$now,'updated_at'=>$now],
            ['slug'=>'premium','name'=>'Premium','category'=>'vip','description'=>'Пълен VIP пакет с приоритетни услуги.','features'=>json_encode(['All Lite benefits','Priority support','10 AWP rounds','Double experience']), 'price'=>8.99,'duration_days'=>30,'accent'=>'#d9e65c','is_featured'=>true,'is_active'=>true,'sort_order'=>20,'created_at'=>$now,'updated_at'=>$now],
            ['slug'=>'platinum','name'=>'Platinum','category'=>'vip','description'=>'Максимални права и отличителен профил.','features'=>json_encode(['All Premium benefits','Custom prefix','Store discount','Exclusive cosmetics']), 'price'=>20.99,'duration_days'=>30,'accent'=>'#a76dff','is_featured'=>false,'is_active'=>true,'sort_order'=>30,'created_at'=>$now,'updated_at'=>$now],
            ['slug'=>'diamond','name'=>'Diamond','category'=>'vip','description'=>'Колекционерски статус за най-лоялните членове.','features'=>json_encode(['Diamond role','Animated profile accent','Priority queue']), 'price'=>40.99,'duration_days'=>30,'accent'=>'#ff4fc4','is_featured'=>false,'is_active'=>true,'sort_order'=>40,'created_at'=>$now,'updated_at'=>$now],
            ['slug'=>'crystal','name'=>'Crystal','category'=>'vip','description'=>'Премиум community пакет с всички екстри.','features'=>json_encode(['Crystal role','All server bonuses','Community recognition']), 'price'=>60.99,'duration_days'=>30,'accent'=>'#68f0c8','is_featured'=>false,'is_active'=>true,'sort_order'=>50,'created_at'=>$now,'updated_at'=>$now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('balance_transactions');
        Schema::dropIfExists('store_orders');
        Schema::dropIfExists('store_products');
        Schema::dropIfExists('player_stats');
    }
};
