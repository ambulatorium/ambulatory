<?php

use Ambulatory\Invitation;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
