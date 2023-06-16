<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserRegistrationTest extends TestCase
{  
    use RefreshDatabase;

    public function testUserRegistrationWithValidData(): void
    {
        $userData=[
            "username"=> "naveen",
            "email"=>"naveen@gmail.com",
            "password"=> "Naveen@1234",
            "confirm_password"=> "Naveen@1234",
            "phone"=> "9888890000"];
        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201)
            ->assertJson([
            'message' => 'Registration successfully.',
            ]);
    }

    public function testUserRegistrationWithMissingFields()
    {
        $userData=[];
        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Not Registered.',
            ]);
    }

    public function testUsernameEmailPhoneShouldBeUnique()
    {
        $userData=[
            "username"=> "naveen",
            "email"=>"naveen@gmail.com",
            "phone"=> "9888890000"];
        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Not Registered.',
            ]);
    }

    public function testUserPasswordAndConfirm_PasswordShouldNotBeMatch()
    {
        $userData=[
            'password' => 'Naveen@1234',
            'confirm_password'=> 'veen@1234'];
        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Not Registered.',
            ]);
    }
}
