<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Reliqui\Ambulatory\Invitation;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Invitation::class, function (Faker $faker) {
    $roles = ['Doctor', 'Admin'];

    $email = $faker->unique()->safeEmail();

    return [
        'email' => $email,
        'role' => $faker->randomElement($roles),
        'token' => Str::limit(md5($email.Str::random()), 25, ''),
    ];
});
