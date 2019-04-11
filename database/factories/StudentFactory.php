<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Student::class, function (Faker $faker) {
    return [
        'contractType' =>  $faker->numberBetween(1, 2),
        'gender' =>  $faker->numberBetween(1, 2),
        'ambassador_id' => 1,
        'feedback' => $faker->sentence,
        'email' => $faker->email,
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'phoneNumber' => $faker->phoneNumber,
        'status' => $faker->numberBetween(1,3),
        'workPermit' => $faker->boolean,
        'hash' => $faker->uuid
    ];
});
