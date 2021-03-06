<?php

namespace Ambulatory\Policies;

use Ambulatory\User;
use Ambulatory\Schedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctorSchedulePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user may manage a schedule.
     *
     * @param  User  $user
     * @param  Schedule  $schedule
     * @return bool
     */
    public function manage(User $user, Schedule $schedule)
    {
        return $user->doctorProfile->id === $schedule->doctor_id;
    }
}
