<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SalesTest extends TestCase
{
    public function test_sell_a_product_out_of_stock(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->post('api/products/sell/CA-000001');
        $this->assertDatabaseHas('products', [
            'sku' => 'CA-000001',
            'stock' => 0
        ]);
        $response->assertStatus(500);
    }

    public function test_sell_a_product(): void
    {
        DB::table('sales')->truncate();
        /** @var Product $product */
        $product = Product::query()->find('TM-000001');
        $product->stock = 10;
        $product->save();

        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->post('api/products/sell/' . $product->sku);
        $this->assertDatabaseHas('products', [
            'sku' => $product->sku,
            'stock' => 9
        ]);
        $response->assertStatus(200);
    }

    public function test_get_sold_products_endpoint(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->get('api/sales');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "product_sku" => "TM-000001",
        ]);
    }

    public function test_get_total_income_endpoint(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->get('api/sales/total');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "data" => '850.99',
        ]);
    }
}
