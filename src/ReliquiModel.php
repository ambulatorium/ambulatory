<?php

namespace Reliqui\Ambulatory;

use Illuminate\Database\Eloquent\Model;

abstract class ReliquiModel extends Model
{
    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    public function getConnectionName()
    {
        return config('reliqui.database_connection');
    }
}
