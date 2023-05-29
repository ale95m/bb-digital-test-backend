<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var User $userAdmin */
        $userAdmin = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $userAdmin->roles()->attach(Role::ADMIN);

        /** @var User $userEditor */
        $userEditor = \App\Models\User::factory()->create([
            'name' => 'Test User2',
            'email' => 'test2@example.com',
        ]);
        $userEditor->roles()->attach(Role::EDITOR)
        ;
        \App\Models\User::factory(10)->create();
    }
}
