<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
    }

    public function testUserLoginWithValidData()
    {
        $userData=[
            "username"=> "naveen",
            "email"=>"naveen@gmail.com",
            "password"=> "Naveen@1234",
            "confirm_password"=> "Naveen@1234",
            "phone"=> "9888890000"];
            $response = $this->postJson('/api/register', $userData);

        $user = ['email' => 'naveen@gmail.com', 'password' => 'Naveen@1234'];
        $this->json('POST', '/api/login', $user)
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);
    }

    public function testUserLoginWithInValidData()
    {

        $user = ['email' => 'na@gmail.com', 'password' => 'Naveen@1234'];
        $this->json('POST', '/api/login', $user)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'log in failed.',
            ]);
    }
}
