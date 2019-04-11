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

$factory->define(\App\Models\School::class, function (Faker $faker) {
    return [
        'address' => $faker->address,
        'internalStructure' => $faker->numberBetween(1,4),
        'name' => $faker->company . " School",
        'sponsored' => $faker->numberBetween(0, 35),
        'targeted' => $faker->boolean,
        'website' => $faker->optional()->url
    ];
});
