<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCRUDTest extends TestCase
{

    public function test_create_a_product_from_an_admin(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->post('api/products', [
            'name' => 'Test product',
            'sku' => 'TP-0001',
            'description' => 'Test product',
            'price' => 100,
            'category_id' => 4
        ]);
        $response->assertJsonFragment([
            "name" => "Test product",
            "sku" => "TP-0001",
            "description" => "Test product",
            "price" => 100,
            "category_id" => 4,
        ]);
        $this->assertDatabaseHas('products', [
            'sku' => 'TP-0001',
        ]);
        $response->assertStatus(200);
    }

    public function test_update_a_product_from_an_admin(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->put('api/products/TP-0001', [
            'name' => 'Test product changed',
            'description' => 'Test product changed',
            'price' => 200,
            'category_id' => 5
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'sku' => 'TP-0001',
            'name' => 'Test product changed',
            'description' => 'Test product changed',
            'price' => 200,
            'category_id' => 5
        ]);
    }

    public function test_delete_a_product_from_an_admin(): void
    {
        /** @var User $user */
        $user = User::query()->find(1);
        $response = $this->actingAs($user)->delete('api/products/TP-0001');
        $response->assertJsonFragment([
            "sku" => "TP-0001",
        ]);
        $this->assertDatabaseMissing('products', [
            'sku' => 'TP-0001',
        ]);
        $response->assertStatus(200);
    }

    public function test_create_a_product_from_an_editor(): void
    {
        /** @var User $user */
        $user = User::query()->find(2);
        $response = $this->actingAs($user)->post('api/products', [
            'name' => 'Test product',
            'sku' => 'TP-0001',
            'description' => 'Test product',
            'price' => 100,
            'category_id' => 4
        ]);
        $response->assertJsonFragment([
            "name" => "Test product",
            "sku" => "TP-0001",
            "description" => "Test product",
            "price" => 100,
            "category_id" => 4,
        ]);
        $this->assertDatabaseHas('products', [
            'sku' => 'TP-0001',
        ]);
        $response->assertStatus(200);
    }

    public function test_update_a_product_from_an_editor(): void
    {
        /** @var User $user */
        $user = User::query()->find(2);
        $response = $this->actingAs($user)->put('api/products/TP-0001', [
            'name' => 'Test product changed',
            'description' => 'Test product changed',
            'price' => 200,
            'category_id' => 5
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'sku' => 'TP-0001',
            'name' => 'Test product changed',
            'description' => 'Test product changed',
            'price' => 200,
            'category_id' => 5
        ]);
    }

    public function test_delete_a_product_from_an_editor(): void
    {
        /** @var User $user */
        $user = User::query()->find(2);
        $response = $this->actingAs($user)->delete('api/products/TP-0001');
        $response->assertJsonFragment([
            "sku" => "TP-0001",
        ]);
        $this->assertDatabaseMissing('products', [
            'sku' => 'TP-0001',
        ]);
        $response->assertStatus(200);
    }

    public function test_create_a_product_from_an_user(): void
    {
        /** @var User $user */
        $user = User::query()->find(3);
        $response = $this->actingAs($user)->post('api/products', [
            'name' => 'Test product',
            'sku' => 'TP-0001',
            'description' => 'Test product',
            'price' => 100,
            'category_id' => 4
        ]);

        $this->assertDatabaseMissing('products', [
            'sku' => 'TP-0001',
        ]);
        $response->assertStatus(403);
    }

    public function test_update_a_product_from_an_user(): void
    {
        /** @var User $user */
        $user = User::query()->find(3);
        $response = $this->actingAs($user)->put('api/products/CA-000001', [
            'name' => 'Test product changed',
            'description' => 'Test product changed',
            'price' => 200,
            'category_id' => 5
        ]);
        $response->assertStatus(403);

    }

    public function test_delete_a_product_from_an_user(): void
    {
        /** @var User $user */
        $user = User::query()->find(3);
        $response = $this->actingAs($user)->delete('api/products/CA-000001');
        $this->assertDatabaseHas('products', [
            'sku' => 'CA-000001',
        ]);
        $response->assertStatus(403);
    }
}
