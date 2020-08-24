<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserInfo;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(UserInfo::class, function (Faker $faker) {
    return [
        
        'name'=>$faker->name,
        'address'=>$faker->address,
        // limited, not the same with validation fields 
        'age'=>$faker->numberBetween($min = 20, $max = 70),
        'salary'=>$faker->numberBetween($min = 10000, $max = 1000000),
    ];
});
