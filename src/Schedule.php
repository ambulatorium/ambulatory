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
     * Get the availabilities attribute.
     *
     * @return array
     */
    public function getAvailabilitiesAttribute()
    {
        return $this->getAvailabilities();
    }

    /**
     * The schedule availabilities structure with the doctor working hours.
     *
     * @return array
     */
    public function getAvailabilities()
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

    /**
     * Check the availability of schedule.
     *
     * @param  string  $incomingDate
     * @return bool
     */
    public function checkAvailability($incomingDate)
    {
        $slots = $this->availabilitySlots($incomingDate);

        $available = Arr::where($slots, function ($value) use ($incomingDate) {
            return $value === date('H:i', strtotime($incomingDate));
        });

        return filled($available);
    }

    /**
     * The schedule availability slots.
     *
     * @param  string  $incomingDate
     * @return mixed
     */
    public function availabilitySlots($incomingDate)
    {
        $date = Carbon::parse($incomingDate)->toDateString();

        $availability = $this->availabilities()->whereDate('date', $date);

        if ($availability->exists()) {
            return $this->customAvailabilitySlot($availability->first()->toArray());
        }

        return $this->defaultAvailabilitySlot($incomingDate);
    }

    /**
     * Find the default availability slots of schedule.
     *
     * @param  string  $incomingDate
     * @return mixed
     */
    protected function defaultAvailabilitySlot($incomingDate)
    {
        $startTime = 0;
        $endTime = 0;

        $doctorAvailability = $this->doctor->getAvailability($incomingDate);

        if (filled($doctorAvailability)) {
            $startTime = strtotime($doctorAvailability['intervals']['from']);
            $endTime = strtotime($doctorAvailability['intervals']['to']);
        }

        return $this->calculateTimeSlots($startTime, $endTime);
    }

    /**
     * Find the custom availability slots of schedule.
     *
     * @param  array  $availability
     * @return mixed
     */
    protected function customAvailabilitySlot($availability)
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
