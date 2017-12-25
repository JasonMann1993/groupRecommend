<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Member::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->userName,
        'avatar' => $faker->imageUrl(),
        'type' => 1,
        'group'=>$faker->userName,
        'address' => $faker->address,
        'active'=>1,
    ];
});
