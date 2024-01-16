<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_signup(): void
    {

        $user = User::factory()->make();

        $payload = [
            "name" => $user->name,
            "email" => $user->email,
            "password" => 'password'
        ];

        $response = $this->post('/api/register', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'token', 'user'
                ]
            ]);
    }

    public function test_user_can_signin(): void
    {

        $user = User::factory()->create();

        $payload = [
            "email" => $user->email,
            "password" => 'password'
        ];

        $response = $this->post('/api/login', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'token', 'user'
                ]
            ]);

    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->postJson('/api/logout');

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
        ]);

        $response->assertStatus(200);
    }

}
