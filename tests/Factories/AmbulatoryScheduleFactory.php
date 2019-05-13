<?php

use Faker\Generator as Faker;
use Reliqui\Ambulatory\Doctor;
use Reliqui\Ambulatory\Schedule;
use Reliqui\Ambulatory\HealthFacility;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Schedule::class, function (Faker $faker) {
    return [
        'start_date_time' => now()->toDateTimeString(),
        'end_date_time' => now()->addDays(6)->toDateTimeString(),
        'estimated_service_time_in_minutes' => Schedule::ESTIMATED_SERVICE_TIME,
        'doctor_id' => factory(Doctor::class),
        'health_facility_id' => factory(HealthFacility::class),
    ];
});
