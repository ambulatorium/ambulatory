<?php

namespace Reliqui\Ambulatory;

class Ambulatory
{
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
