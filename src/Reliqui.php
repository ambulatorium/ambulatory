<?php

namespace Reliqui\Ambulatory;

class Reliqui
{
    /**
     * Get the default JavaScript variables for Reliqui.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'path' => config('reliqui.path'),
            'user' => auth('reliqui')->check()
                ? auth('reliqui')->user()->only('name', 'avatar', 'role', 'id')
                : null,
        ];
    }
}
