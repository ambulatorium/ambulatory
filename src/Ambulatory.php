<?php

namespace Reliqui\Ambulatory;

use Illuminate\Support\Facades\Gate;

class Ambulatory
{
    /**
     * The policy mappings for reliqui ambulatory.
     *
     * @var array
     */
    protected $policies = [];

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
