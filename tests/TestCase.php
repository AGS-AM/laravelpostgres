<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $user = factory(User::class)->create([
            'name' => 'testingphase',
            'surname' => 'testingphase',
            'username' => 'testingphase',
            'phone' => 12345678,
            'email' => 'testingphase@testingphase.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678ABC'),
            'power' => 10,
            'remember_token' => '123',
        ]);
        Artisan::call('passport:install');
    }
}