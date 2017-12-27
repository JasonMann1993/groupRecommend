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
        'name'    => $faker->userName,
        'avatar'  => $faker->imageUrl(),
        'type'    => 1,
        'group'   => $faker->userName,
        'address' => $faker->address,
        'active'  => 1,
    ];
});

$factory->define(App\Models\Group::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->name,
        'logo'      => $faker->imageUrl(),
        'desc'      => $faker->sentence,
        'address'   => $faker->address,
        'latitude'  => $faker->latitude,
        'longitude' => $faker->longitude,
        'wx'        => $faker->name,
        'qr_code'   => $faker->imageUrl(),
        'order'     => $faker->numberBetween(0, 100)
    ];
});

$factory->define(App\Models\Business::class, function (Faker\Generator $faker) {
    $userIds = \App\Models\Member::all()->pluck('id')->toArray();
    return [
        'member_id'      => $faker->randomElement($userIds),
        'name'      => $faker->name,
        'logo'      => $faker->imageUrl(),
        'desc'      => $faker->sentence,
        'address'   => $faker->address,
        'latitude'  => $faker->latitude,
        'longitude' => $faker->longitude,
        'order'     => $faker->numberBetween(0, 100)
    ];
});
