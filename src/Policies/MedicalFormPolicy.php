<?php

namespace Ambulatory\Policies;

use Ambulatory\MedicalForm;
use Ambulatory\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MedicalFormPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user may manage a medical form.
     *
     * @param  User  $user
     * @param  MedicalForm  $medicalForm
     * @return bool
     */
    public function manage(User $user, MedicalForm $medicalForm)
    {
        return $user->id === $medicalForm->user_id;
    }
}
