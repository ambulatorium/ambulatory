<?php

namespace Ambulatory;

use Illuminate\Database\Eloquent\Model;

abstract class AmbulatoryModel extends Model
{
    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    public function getConnectionName()
    {
        return config('ambulatory.database_connection');
    }
}
