<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanAuthenticateWithEmail()
    {
        $password = 'test';
        $user = User::factory()->create(['password' => Hash::make($password)]);
        $response = $this->post('api/auth/login', [
            'email' => $user['email'],
            'password' => $password,
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'token'
        ]);
    }

    public function testUserCanAuthenticateWithUsername()
    {
        $password = 'test';
        $user = User::factory()->create(['password' => Hash::make($password)]);
        $response = $this->post('api/auth/login', [
            'username' => $user['username'],
            'password' => $password,
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'token'
        ]);
    }

    public function testUserCanSignup()
    {
        $user = User::factory()->raw();
        $response = $this->post('api/auth/signup', [
            'email' => $user['email'],
            'username' => $user['username'],
            'password' => $user['password'],
        ]);

        $response->assertCreated();

        $response->assertJsonStructure([
            'id',
            'token',
            'email',
        ]);

        $response->assertJson([
            'email' => $user['email']
        ]);
    }
}
