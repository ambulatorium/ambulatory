<?php

namespace Reliqui\Ambulatory;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Boot up the trait.
     */
    public static function bootHasUuid()
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}