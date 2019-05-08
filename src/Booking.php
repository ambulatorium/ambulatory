<?php

namespace Reliqui\Ambulatory;

class Booking extends AmbulatoryModel
{
    const DONE = 1;
    const ACTIVE = 2;
    const EXPIRED = 3;

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
    protected $table = 'ambulatory_bookings';

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
     * Status of booking.
     *
     * @return int
     */
    public function status()
    {
        return (int) $this->status;
    }

    /**
     * Status of booking is done.
     *
     * @return boolean
     */
    public function isDone()
    {
        return $this->status() === self::DONE;
    }

    /**
     * Status of booking is active.
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->status() === self::ACTIVE;
    }

    /**
     * Status of booking is expired.
     *
     * @return boolean
     */
    public function isExpired()
    {
        return $this->status() === self::EXPIRED;
    }

    /**
     * The booking schedule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    /**
     * The booking medical form.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medicalForm()
    {
        return $this->belongsTo(MedicalForm::class, 'medical_form_id');
    }
}
