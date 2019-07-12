<?php

use Ambulatory\User;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail(),
        'password' => $faker->password(),
        'avatar' => $faker->imageUrl($width = 400, $height = 400),
    ];
});
