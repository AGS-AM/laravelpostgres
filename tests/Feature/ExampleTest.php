<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\User;

use SebastianBergmann\Environment\Console;

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

        $response->assertStatus(302)->assertRedirect('/login');
    }
    public function testCleanRegister()
    {

        $registerData = [
            'name' => 'testingreg',
            'surname' => 'testingreg',
            'username' => 'testingreg',
            'phone' => 12345678,
            'email' => 'testingreg@testingreg.com',
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
        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);

        //echo $this->get('user_infos/get_data')->getContent();
        $this->assertAuthenticated();
    }
    public function testFailedLogin()
    {
        $loginData = ['username' => 'testingfail', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertSessionHas('error', 'Email-Address And Password Are Wrong.');
        $this->assertGuest();
    }
    public function testReadDatatables()
    {
        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);
        //REQUIRES LOGIN

        $this->json('GET', 'user_infos/get_data')
            ->assertJson(
                [
                    'recordsTotal' => 501,
                ]
            );
        //Looking to see if the seeded 50 and recently added 1 makes 51
        //also checks last json for recent user added
        // $response = $this->getJson('/user_infos/get_data');
        // $response->assertJson(
        //     [
        //         'recordsTotal' => 51,
        //     ]);
    }

    public function testAddDatatables()
    {
        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);
        //REQUIRES LOGIN
        $newuser = [
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
        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);
        //REQUIRES LOGIN
        $newuser = [
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
        $loginData = ['username' => 'testingphase', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);
        //REQUIRES LOGIN

        for ($i = 1; $i < 11; $i++) {
            //echo "\n Testing Mass Delete " . $i;
            $this->json('DELETE', '/user_infos/' . $i, ['Accept' => 'application/json'])
                ->assertStatus(204);
                //power 2 can delete via json cant do it thru web
        }
        $this->json('GET', 'user_infos/get_data')
            ->assertJson(
                [
                    'recordsTotal' => 491,
                ]
            );
    }
    public function testPowerDatatables()
    {
        $user = factory(User::class)->create([
            'name' => 'testingpow',
            'surname' => 'testingpow',
            'username' => 'testingpow',
            'phone' => 12345678,
            'email' => 'testingpow@testingpow.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678ABC'),
            'power' => 0,
            'remember_token' => '123',
        ]);
        $loginData = ['username' => 'testingpow', 'password' => '12345678ABC'];

        $this->json('POST', '/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(202);
        //REQUIRES LOGIN


        $this->json('DELETE', '/user_infos/1', ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson(['errors' => [0 => 'Not Enough Power']]);
    }
}
