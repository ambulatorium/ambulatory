<?php

namespace Reliqui\Ambulatory\Rules;

use Illuminate\Contracts\Validation\Rule;

class BookingAvailabilityRule implements Rule
{
    /**
     * The schedule of doctor
     *
     * @var \Reliqui\Ambulatory\Schedule
     */
    protected $schedule;

    /**
     * Create a new rule instance.
     *
     * @param  \Reliqui\Ambulatory\Schedule  $schedule
     * @return void
     */
    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->schedule->checkAvailability($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The preferred date time is not available.';
    }
}
