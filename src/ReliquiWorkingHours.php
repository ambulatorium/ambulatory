<?php

namespace Reliqui\Ambulatory;

class ReliquiWorkingHours extends ReliquiModel
{
    const ESTIMATED_SERVICE_TIME = 15;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reliqui_working_hours';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Doctor's work schedule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(ReliquiDoctor::class, 'doctor_id');
    }

    /**
     * Doctor location work.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workLocation()
    {
        return $this->belongsTo(ReliquiHealthcareLocation::class, 'location_id');
    }
}
