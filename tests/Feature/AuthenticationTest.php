<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLoginWithCorrectCredentials(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(201);
    }

    public function testUserCanRegisterWithCorrectCredentials(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Jhon Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
               'access_token',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Jhon Doe',
            'email' => 'john@example.com'
        ]);
    }

    public function testUserCannotLoginWithIncorrectCredentials(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(422);
    }

    public function testUserCannotRegisterWithIncorrectCredentials()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'jhon Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'wrong_password',
        ]);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('users', [
            'name' => 'Jhon Doe',
            'email' => 'john@example.com',
        ]);
    }
}
