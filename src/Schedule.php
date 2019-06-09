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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['availabilities'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reliqui_schedules';

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_date_time',
        'end_date_time',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'estimated_service_time_in_minutes' => 'integer',
    ];

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
     * The availabilities of schedule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'schedule_id');
    }

    /**
     * Add a availability to the schedule.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addAvailability(array $attributes)
    {
        return $this->availabilities()->create($attributes);
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

    /**
     * Get the schedule availabilities within the working hours.
     *
     * @return array
     */
    public function getAvailabilitiesAttribute()
    {
        return array_merge($this->availabilities()->get()->toArray(), $this->doctorWorkingHours());
    }

    /**
     * The working hours of doctor.
     *
     * @return array
     */
    public function doctorWorkingHours()
    {
        return $this->doctor->getWorkingHours();
    }
}
