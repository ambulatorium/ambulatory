<?php

use Reliqui\Ambulatory\User;
use Faker\Generator as Faker;
use Reliqui\Ambulatory\Doctor;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Doctor::class, function (Faker $faker) {
    $qualification = ['Doctor of Surgery (DS, DSurg)', 'Doctor of Clinical Medicine (DCM)'];

    return [
        'full_name' => $faker->name,
        'qualification' => $faker->randomElement($qualification),
        'practicing_from' => $faker->date($max = 'now'),
        'professional_statement' => $faker->sentence(5),
        'user_id' => factory(User::class)->create(['type' => User::DOCTOR]),
    ];
});
