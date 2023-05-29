<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::query()->create(['name'=>'Teléfonos móviles']);
        Category::query()->create(['name'=>'Consolas de juegos']);
        Category::query()->create(['name'=>'Muebles para el hogar']);
        Category::query()->create(['name'=>'Electrodomésticos']);
        Category::query()->create(['name'=>'Ropa']);
    }
}
