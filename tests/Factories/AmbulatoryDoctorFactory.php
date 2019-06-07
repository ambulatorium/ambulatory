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
        'practicing_from' => $faker->date(),
        'professional_statement' => $faker->sentence(5),
        'user_id' => factory(User::class)->create(['type' => User::DOCTOR]),
        'working_hours_rule' => 'DTSTART:20190607T090000Z
        RRULE:FREQ=DAILY;UNTIL=20190607T170000Z;BYDAY=MO,TU,WE,TH,FR',
    ];
});
