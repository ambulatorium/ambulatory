<?php

namespace Reliqui\Ambulatory;

class ReliquiAppointment extends ReliquiModel
{
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
    protected $table = 'reliqui_appointments';

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
     * Doctor account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(ReliquiPatient::class, 'patient_id');
    }

    /**
     * Doctor's schedule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scheduled()
    {
        return $this->belongsTo(ReliquiWorkingHours::class, 'schedule_id');
    }
}