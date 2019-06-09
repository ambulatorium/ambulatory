<?php

use Faker\Generator as Faker;
use Reliqui\Ambulatory\Schedule;
use Reliqui\Ambulatory\Availability;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Availability::class, function (Faker $faker) {
    return [
        'schedule_id' => factory(Schedule::class),
        'type' => 'date',
        'intervals' => [
            [
                'from' => $faker->time(),
                'to' => $faker->time(),
            ],
        ],
        'date' => $faker->date(),
    ];
});
