<?php

use Faker\Generator as Faker;
use Ambulatory\Ambulatory\Specialization;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Specialization::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2),
        'description' => $faker->sentence(4),
    ];
});
