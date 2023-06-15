<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserLoginTest extends TestCase
{
    public function testUserLoginSuccessfully()
    {
        $user = ['email' => 'naveen@gmail.com', 'password' => 'Naveen@1234'];
        $this->json('POST', '/api/login', $user)
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);
    }
}
