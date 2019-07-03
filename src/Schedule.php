<?php

namespace Reliqui\Ambulatory;

use Carbon\Carbon;
use Illuminate\Support\Arr;

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
        'start_date',
        'end_date',
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
     * The custom availabilities of schedule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customAvailabilities()
    {
        return $this->hasMany(Availability::class, 'schedule_id');
    }

    /**
     * Estimated service time in minutes of schedule.
     *
     * @return int
     */
    public function estim()
    {
        return $this->estimated_service_time_in_minutes;
    }

    /**
     * Add a availability to the schedule.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addCustomAvailability(array $attributes)
    {
        return $this->customAvailabilities()->create($attributes);
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
     * Get the availabilities attribute.
     *
     * @return array
     */
    public function getAvailabilitiesAttribute()
    {
        return $this->availabilities();
    }

    /**
     * Get all schedule availabilities.
     *
     * @return array
     */
    public function availabilities()
    {
        return array_merge($this->customAvailabilities()->get()->toArray(), $this->doctor->workingHours());
    }

    /**
     * Check the availability slot of schedule.
     *
     * @param  string  $dateTime
     * @return bool
     */
    public function checkAvailabilitySlot($dateTime)
    {
        $slots = $this->availabilitySlots($dateTime);

        $available = Arr::where($slots, function ($value) use ($dateTime) {
            return $value === date('H:i', strtotime($dateTime));
        });

        return filled($available);
    }

    /**
     * The schedule availability slots.
     *
     * @param  string  $dateTime
     * @return mixed
     */
    public function availabilitySlots($dateTime)
    {
        $date = Carbon::parse($dateTime)->toDateString();

        $customAvailability = $this->customAvailabilities()->whereDate('date', $date);

        if ($customAvailability->exists()) {
            return $this->customAvailabilitySlots($customAvailability->first()->toArray());
        }

        return $this->defaultAvailabilitySlots($dateTime);
    }

    /**
     * Get the default availability slots of schedule.
     *
     * @param  string  $dateTime
     * @return mixed
     */
    protected function defaultAvailabilitySlots($dateTime)
    {
        $startTime = 0;
        $endTime = 0;

        $doctorAvailability = $this->doctor->workingHourSlots($dateTime);

        if (filled($doctorAvailability)) {
            $startTime = strtotime($doctorAvailability['intervals']['from']);
            $endTime = strtotime($doctorAvailability['intervals']['to']);
        }

        return $this->calculateTimeSlots($startTime, $endTime);
    }

    /**
     * Get the custom availability slots of schedule.
     *
     * @param  array  $availability
     * @return mixed
     */
    protected function customAvailabilitySlots(array $availability)
    {
        $slots = collect($availability['intervals'])->map(function ($intervals) {
            $startTime = strtotime($intervals['from']);
            $endTime = strtotime($intervals['to']);

            return $this->calculateTimeSlots($startTime, $endTime);
        })->toArray();

        return Arr::collapse($slots);
    }

    /**
     * Calculate availability time slots.
     *
     * @param  int  $startTime
     * @param  int  $endTime
     * @return array
     */
    protected function calculateTimeSlots($startTime, $endTime)
    {
        $duration = $this->estim() * 60;

        $timeSlots = [];

        while ($startTime <= $endTime) {
            $timeSlots[] = date('H:i', $startTime);

            $startTime += $duration;
        }

        return $timeSlots;
    }
}
