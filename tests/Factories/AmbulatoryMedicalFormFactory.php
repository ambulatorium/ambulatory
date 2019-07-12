<?php

use Ambulatory\User;
use Ambulatory\MedicalForm;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(MedicalForm::class, function (Faker $faker) {
    $gender = ['Male', 'Female'];

    $status = ['Single', 'Married'];

    return [
        'form_name' => $faker->sentence(2),
        'full_name' => $faker->name,
        'dob' => $faker->date(),
        'gender' => $faker->randomElement($gender),
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => null,
        'zip_code' => $faker->postcode,
        'cell_phone' => $faker->phoneNumber,
        'home_phone' => null,
        'marital_status' => $faker->randomElement($status),
        'user_id' => factory(User::class),
    ];
});
