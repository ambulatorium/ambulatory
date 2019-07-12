<?php

namespace Ambulatory\Policies;

Use Ambulatory\User;
Use Ambulatory\Availability;
use Illuminate\Auth\Access\HandlesAuthorization;

class AvailabilityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user may manage a availability.
     *
     * @param  User  $user
     * @param  Schedule  $availability
     * @return bool
     */
    public function manage(User $user, Availability $availability)
    {
        return $user->doctorProfile->id === $availability->schedule->doctor_id;
    }
}
