<?php

use Faker\Generator;
use Reliqui\Ambulatory\User;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Generator $faker) {
    return [
        'id' => $faker->uuid,
        'name' => $faker->title,
        'email' => $faker->unique()->safeEmail(),
        'password' => $faker->password(),
    ];
});
