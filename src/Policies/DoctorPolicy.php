<?php

namespace Ambulatory\Policies;

use Ambulatory\Doctor;
use Ambulatory\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given doctor profile can be updated by the user.
     *
     * @param  User  $user
     * @param  Doctor  $doctor
     * @return bool
     */
    public function update(User $user, Doctor $doctor)
    {
        return $user->id === $doctor->user_id;
    }
}
