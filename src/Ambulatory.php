<?php

namespace Ambulatory;

use Illuminate\Support\Facades\Gate;
use Ambulatory\Policies\DoctorPolicy;
use Ambulatory\Policies\MedicalFormPolicy;
use Ambulatory\Policies\AvailabilityPolicy;
use Ambulatory\Policies\DoctorSchedulePolicy;

class Ambulatory
{
    /**
     * The policy mappings for ambulatory.
     *
     * @var array
     */
    protected $policies = [
        Doctor::class => DoctorPolicy::class,
        Schedule::class => DoctorSchedulePolicy::class,
        MedicalForm::class => MedicalFormPolicy::class,
        Availability::class => AvailabilityPolicy::class,
    ];

    /**
     * Register ambulatory policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Get the default JavaScript variables for Ambulatory.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'path' => config('ambulatory.path'),
            'user' => auth('ambulatory')->check()
                ? auth('ambulatory')->user()->scriptVariables()
                : null,
        ];
    }
}
