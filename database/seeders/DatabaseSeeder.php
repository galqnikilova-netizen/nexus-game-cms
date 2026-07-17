<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Server;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(['email' => 'admin@nexus.local'], ['name' => 'NEXUS Admin', 'password' => Hash::make('change-me'), 'role' => 'super_admin', 'balance' => 250]);
        foreach ([
            ['name'=>'NEXUS #1 PUBLIC','address'=>'127.0.0.1:27015','mode'=>'PUBLIC','map'=>'de_mirage','players'=>28,'max_players'=>32,'status'=>'online'],
            ['name'=>'NEXUS #2 RETAKES','address'=>'127.0.0.1:27016','mode'=>'RETAKES','map'=>'de_inferno','players'=>19,'max_players'=>24,'status'=>'online'],
        ] as $server) Server::query()->firstOrCreate(['address'=>$server['address']], $server);
        foreach ([
            ['name'=>'NEXUS PRIME','slug'=>'nexus-prime','type'=>'vip_admin','price'=>19.99,'duration_days'=>30,'description'=>'Full premium package.'],
            ['name'=>'VIP CORE','slug'=>'vip-core','type'=>'vip','price'=>8.99,'duration_days'=>30,'description'=>'Core VIP benefits.'],
        ] as $product) Product::query()->firstOrCreate(['slug'=>$product['slug']], $product);
    }
}
