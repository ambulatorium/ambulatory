<?php

use Reliqui\Ambulatory\User;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'name' => $faker->title,
        'email' => $faker->unique()->safeEmail(),
        'password' => $faker->password(),
    ];
});
