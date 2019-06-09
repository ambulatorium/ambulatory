<?php

namespace Reliqui\Ambulatory;

use Illuminate\Support\Facades\Gate;
use Reliqui\Ambulatory\Policies\MedicalFormPolicy;
use Reliqui\Ambulatory\Policies\AvailabilityPolicy;
use Reliqui\Ambulatory\Policies\DoctorSchedulePolicy;

class Ambulatory
{
    /**
     * The policy mappings for reliqui ambulatory.
     *
     * @var array
     */
    protected $policies = [
        Schedule::class => DoctorSchedulePolicy::class,
        MedicalForm::class => MedicalFormPolicy::class,
        Availability::class => AvailabilityPolicy::class,
    ];

    /**
     * Register reliqui ambulatory policies.
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
                ? auth('ambulatory')->user()->only('name', 'avatar', 'role', 'id')
                : null,
        ];
    }
}
