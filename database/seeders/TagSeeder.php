<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::query()->create(['name' => 'Nuevo']);
        Tag::query()->create(['name' => 'De segunda mano']);
        Tag::query()->create(['name' => 'Para el hogar']);
        Tag::query()->create(['name' => 'Entretenimiento']);
        Tag::query()->create(['name' => 'Electrónico']);
        Tag::query()->create(['name' => 'Decorativo']);
    }
}
