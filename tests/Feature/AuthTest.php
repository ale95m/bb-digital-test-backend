<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login_with_correct_credentials(): void
    {
        $response = $this->post('api/login', [
            'email'=>'test@example.com',
            'password' => 'password'
        ]);
        $response->assertStatus(200);
    }

    public function test_login_with_wrong_credentials(): void
    {
        $response = $this->post('api/login', [
            'email'=>'test@example.com',
            'password' => 'wrong_password'
        ]);
        $response->assertStatus(401);
    }
}
