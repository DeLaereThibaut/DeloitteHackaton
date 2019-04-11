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

$factory->define(\App\Models\SchoolEvent::class, function (Faker $faker) {
    $startDay = rand(-25, 300);
    $endDay = rand(1, 300);
    return [
        'country_id' => $faker->numberBetween(1, 11),
        'startDate' => \Carbon\Carbon::now()->addDay($startDay),
        'endDate' => \Carbon\Carbon::now()->addDay($startDay)->addHour($endDay),
        'eventPrice' => $faker->randomDigit(0.1, 80),
        'fiscalYear' => $faker->numberBetween(2018, 2022),
        'internal' => $faker->boolean,
        'internalStructure' => $faker->numberBetween(1,4),
        'location' => $faker->city,
        'name' => $faker->company . " " . "Day",
        'type_id' => $faker->numberBetween(1, 13)
    ];
});
