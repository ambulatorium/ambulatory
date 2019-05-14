<?php

namespace Reliqui\Ambulatory;

class Schedule extends AmbulatoryModel
{
    use HasUuid;

    const ESTIMATED_SERVICE_TIME = 15; // minutes

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
    protected $table = 'ambulatory_schedules';

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
     * Doctor location work.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function healthFacility()
    {
        return $this->belongsTo(HealthFacility::class, 'health_facility_id');
    }

    /**
     * The schedules belongs to a doctor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    /**
     * The bookings schedule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'schedule_id');
    }
}
