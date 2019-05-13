<?php

use Faker\Generator as Faker;
use Reliqui\Ambulatory\HealthFacility;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(HealthFacility::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2),
        'address' => $faker->address,
        'city' => $faker->city,
        'country' => $faker->country,
        'zip_code' => $faker->postcode,
    ];
});
