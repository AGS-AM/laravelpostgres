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
    public function testCleanRegister()
    {

        $registerData = [
            'name' => 'testingphase',
            'surname' => 'testingphase',
            'username' => 'testingphase',
            'phone' => 12345678,
            'email' => 'testingphase@testingphase.com',
            'password' => '12345678ABC',
            'password_confirmation' => '12345678ABC'
        ];

        $this->json('POST', '/register', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(201);
    }
    public function testFailedRegister()
    {

        $registerData = [
            'name' => 'testingphase',
            'surname' => 'testingphase',
            'username' => 'testingphase',
            'password_confirmation' => 'ABC'
        ];

        $this->json('POST', '/register', $registerData, ['Accept' => 'application/json'])
            ->assertStatus(422);
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

        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);

        //echo $this->get('user_infos/get_data')->getContent();
        $this->assertAuthenticated();
    }
    public function testFailedLogin()
    {


        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertSessionHas('error', 'Email-Address And Password Are Wrong.');
    }
    public function testReadDatatables()
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

        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);
        //REQUIRES LOGIN
        
        $this->json('GET', 'user_infos/get_data')
        ->assertJson(
            [
                'recordsTotal' => 51,
                'data' => [
                    [],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],['name' => 'testingphase',
                    'surname' => 'testingphase',
                    'username' => 'testingphase',
                    'phone' => 12345678,
                    'email' => 'testingphase@testingphase.com',
                    ]
                ]
            ]);//Looking to see if the seeded 50 and recently added 1 makes 51
            //also checks last json for recent user added
        // $response = $this->getJson('/user_infos/get_data');
        // $response->assertJson(
        //     [
        //         'recordsTotal' => 51,
        //     ]);
    }

    public function testAddDatatables()
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
        
        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);
        //REQUIRES LOGIN
        $newuser =[
            'name' => 'testingphase2',
            'surname' => 'testingphase2',
            'username' => 'testingphase2',
            'phone' => 87654321,
            'email' => 'testingphase2@testingphase2.com',
            'power' => 0,
            'password' => '123456789ABC',
            'passwordConfirm' => '123456789ABC',
        ];

        $this->json('POST', '/user_infos/add', $newuser, ['Accept' => 'application/json'])
            ->assertStatus(201);
        

    }

    public function testEditDatatables()
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
        
        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);
        //REQUIRES LOGIN
        $newuser =[
            'name' => 'testingphase2',
            'surname' => 'testingphase2',
            'username' => 'testingphase2',
            'phone' => 87654321,
            'email' => 'testingphase2@testingphase2.com',
        ];

        $this->json('PUT', '/user_infos/1', $newuser, ['Accept' => 'application/json'])
            ->assertStatus(202);
        

    }
    public function testDeleteDatatables()
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
        
        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);
        //REQUIRES LOGIN


        $this->json('DELETE', '/user_infos/1', ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
    public function testPowerDatatables()
    {
        $user = factory(User::class)->create([
            'name' => 'testingphase',
            'surname' => 'testingphase',
            'username' => 'testingphase',
            'phone' => 12345678,
            'email' => 'testingphase@testingphase.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678ABC'),
            'power' => 0,
            'remember_token' => '123',
        ]);
        
        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);
        //REQUIRES LOGIN


        $this->json('DELETE', '/user_infos/1', ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson(['errors' => [0 =>'Not Enough Power']]);
    }
}
