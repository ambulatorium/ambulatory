<?php

use Faker\Generator as Faker;
use Reliqui\Ambulatory\Doctor;
use Reliqui\Ambulatory\Schedule;
use Reliqui\Ambulatory\HealthFacility;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Schedule::class, function (Faker $faker) {
    // always set date to Monday next week
    $date = today()->parse('Monday next week');

    return [
        'start_date' => $date->toDateTimeString(),
        'end_date' => $date->addDays(4)->toDateTimeString(),
        'estimated_service_time_in_minutes' => Schedule::ESTIMATED_SERVICE_TIME,
        'doctor_id' => factory(Doctor::class),
        'health_facility_id' => factory(HealthFacility::class),
    ];
});
