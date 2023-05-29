<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    public function test_products_count_endpoint(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->get('api/products/get/count');
        $response->assertStatus(200);
        $response->assertJson([
            "status" => "success",
            "message" => "OK",
            "data" => 9,
        ]);
    }

    public function test_products_count_endpoint_with_name_filter(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->get('api/products/get/count?name:like=%galaxy%');
        $response->assertStatus(200);
        $response->assertJson([
            "status" => "success",
            "message" => "OK",
            "data" => 2,
        ]);
    }

    public function test_search_products(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->get('api/products');
        $response->assertStatus(200);
    }

    public function test_search_products_by_sku(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->get('api/products?sku=CV-000001');
        $response->assertJsonFragment([
            "sku" => "CV-000001",
            "name" => "Play Station 5",
        ]);
        $response->assertJsonFragment([
            "total" => 1,
            "per_page" => 10,
            "current_page" => 1,
            "last_page" => 1
        ]);
        $response->assertStatus(200);
    }

    public function test_search_products_by_name(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->get('api/products?name:like=%station%');
        $response->assertJsonFragment([
            "sku" => "CV-000001",
            "name" => "Play Station 5",
        ]);
        $response->assertJsonFragment([
            "total" => 1,
            "per_page" => 10,
            "current_page" => 1,
            "last_page" => 1
        ]);
        $response->assertStatus(200);
    }

    public function test_search_products_by_description(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->get('api/products?description:like=%consola%');
        $response->assertJsonFragment([
            "sku" => "CV-000001",
            "name" => "Play Station 5",
        ]);
        $response->assertJsonFragment([
            "sku" => "CV-000002",
            "name" => "X Box One",
        ]);
        $response->assertJsonFragment([
            "total" => 2,
            "per_page" => 10,
            "current_page" => 1,
            "last_page" => 1
        ]);
        $response->assertStatus(200);
    }

    public function test_search_products_by_price(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->get('api/products?price:<=50');
        $response->assertJsonFragment([
            "sku" => "RA-000001",
            "name" => "Camisa a cuadros",
        ]);
        $response->assertJsonFragment([
            "sku" => "UH-000001",
            "name" => "Mesa de madera",
        ]);
        $response->assertJsonFragment([
            "total" => 2,
            "per_page" => 10,
            "current_page" => 1,
            "last_page" => 1
        ]);
        $response->assertStatus(200);
    }

    public function test_get_products_out_of_stock(): void
    {
        /** @var Product $product */
        $product = Product::query()->find('TM-000001');
        $product->stock = 10;
        $product->save();

        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->get('api/products/get/out_of_stock');
        $response->assertJsonFragment([
            "sku" => "RA-000001",
            "name" => "Camisa a cuadros",
        ]);
        $response->assertJsonFragment([
            "sku" => "UH-000001",
            "name" => "Mesa de madera",
        ]);
        $response->assertJsonMissing([
            "sku" => "TM-000001",
        ]);
        $response->assertStatus(200);
    }

}
