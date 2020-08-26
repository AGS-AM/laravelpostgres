<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }
    public function testCleanLogin()
    {
        $user = factory(User::class)->create([
            'name' => 'testingphase',
            'surname' => 'testingphase',
            'username' => 'testingphase',
            'phone' => 12345678,
            'email' => 'testingphase@testingphase.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678ABC'),
            'power' => 2,
            'remember_token' => '123',
        ]);

        $loginData = ['username' => 'testingphase', 'password' => '123456782ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);


        $this->assertAuthenticated();
    }
    
}
