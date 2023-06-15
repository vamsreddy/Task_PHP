<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserRegistrationTest extends TestCase
{
    public function test_getIndex(): void
    {
        $response = $this->get('/api/index');

        $response->assertStatus(200);
    }
    
    public function testRegisterWithoutRequiredParametersShouldFail(): void
    {
        $this
            ->post('/api/register')
            ->assertUnprocessable()
            ->assertJsonFragment([
                'username' => ['The username field is required.'],
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
                'phone' => ['The phone field is required.'],
            ]);
    }

    public function testRegisterSuccessfull()
    {
        $register = [
            'username' => 'rohit',
            'email' => 'rohit@gmail.com',
            'password' => 'Testpass@123',
            'confirm_password' => 'Testpass@123',
            'phone' => '9800000000'
        ];

        $this->json('POST', 'api/register', $register)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'username',
                    'email',
                    'created_at',
                    'updated_at'
                ]                
            ]);
    }
}
