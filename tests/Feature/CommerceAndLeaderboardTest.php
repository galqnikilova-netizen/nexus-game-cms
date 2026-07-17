<?php
namespace Tests\Feature;
use App\Models\GameServer;
use App\Models\PlayerStat;
use App\Models\StoreProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class CommerceAndLeaderboardTest extends TestCase {
    use RefreshDatabase;
    public function test_leaderboard_renders_ranked_players():void {
        $user=User::factory()->create(['name'=>'Ranked Player']);
        PlayerStat::create(['user_id'=>$user->id,'score'=>1200,'kills'=>50,'deaths'=>25]);
        $this->get('/leaderboard')->assertOk()->assertSee('Ranked Player')->assertSee('1,200');
    }
    public function test_member_can_purchase_product_with_balance():void {
        $user=User::factory()->create(['balance'=>50]);
        $product=StoreProduct::query()->firstOrFail();
        $this->actingAs($user)->post(route('shop.purchase',$product),[])->assertRedirect();
        $this->assertDatabaseHas('store_orders',['user_id'=>$user->id,'store_product_id'=>$product->id,'status'=>'completed']);
        $this->assertDatabaseHas('balance_transactions',['user_id'=>$user->id,'direction'=>'debit','status'=>'completed']);
        $this->assertEquals(50-(float)$product->price,(float)$user->fresh()->balance);
    }
    public function test_guest_cannot_purchase_and_member_can_request_topup():void {
        $product=StoreProduct::query()->firstOrFail();
        $this->post(route('shop.purchase',$product))->assertRedirect('/login');
        $user=User::factory()->create();
        $this->actingAs($user)->post(route('balance.store'),['amount'=>25,'provider'=>'stripe'])->assertRedirect();
        $this->assertDatabaseHas('balance_transactions',['user_id'=>$user->id,'amount'=>25,'status'=>'pending']);
    }
}
