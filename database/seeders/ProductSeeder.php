<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product= Product::query()->create([
            'sku' => 'TM-000001',
            'name' => 'iPhone 14',
            'description' => 'Teléfono movil de alta gama',
            'price' => 850.99,
            'category_id' => 1
        ]);
        /** @var Product $product */
        $product->images()->create(['url'=>'https://images.com/image_demo']);
        $product->images()->create(['url'=>'https://images.com/image_demo2']);

        $product= Product::query()->create([
            'sku' => 'TM-000002',
            'name' => 'Galaxy s22',
            'description' => 'Teléfono movil de alta gama',
            'price' => 750.99,
            'category_id' => 1
        ]);
        $product->images()->create(['url'=>'https://images.com/image_demo3']);
        $product->images()->create(['url'=>'https://images.com/image_demo4']);
        $product= Product::query()->create([
            'sku' => 'TM-000003',
            'name' => 'Galaxy J5',
            'description' => 'Teléfono movil de alta gama',
            'price' => 122.50,
            'category_id' => 1
        ]);
        $product->images()->create(['url'=>'https://images.com/image_demo5']);
        $product->images()->create(['url'=>'https://images.com/image_demo6']);

        $product= Product::query()->create([
            'sku' => 'CV-000001',
            'name' => 'Play Station 5',
            'description' => 'Consola de Sony',
            'price' => 500,
            'category_id' => 2
        ]);
        $product->images()->create(['url'=>'https://images.com/image_demo7']);
        $product->images()->create(['url'=>'https://images.com/image_demo8']);
        $product= Product::query()->create([
            'sku' => 'CV-000002',
            'name' => 'X Box One',
            'description' => 'Consola de Microsoft',
            'price' => 400,
            'category_id' => 2
        ]);
        $product->images()->create(['url'=>'https://images.com/image_demo9']);

        $product= Product::query()->create([
            'sku' => 'UH-000001',
            'name' => 'Mesa de madera',
            'description' => 'Mesa de madera ideal para la cocina del hogar',
            'price' => 40,
            'category_id' => 3
        ]);
        $product->images()->create(['url'=>'https://images.com/image_demo10']);
        $product= Product::query()->create([
            'sku' => 'UH-000002',
            'name' => 'Cama personal',
            'description' => 'Cama para niños',
            'price' => 60,
            'category_id' => 3
        ]);

        $product= Product::query()->create([
            'sku' => 'RA-000001',
            'name' => 'Camisa a cuadros',
            'description' => 'Ideal para ocaciones formales',
            'price' => 20,
            'category_id' => 5
        ]);
        $product= Product::query()->create([
            'sku' => 'CA-000001',
            'name' => 'NIKE Air Force 1',
            'description' => 'Calzado para niños',
            'price' => 99.99,
            'category_id' => 5
        ]);
        $product->images()->create(['url'=>'https://images.com/image_demo13']);
        $product->images()->create(['url'=>'https://images.com/image_demo14']);
    }
}
