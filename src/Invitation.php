<?php

namespace Ambulatory\Ambulatory;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Ambulatory\Ambulatory\Mail\CredentialEmail;
use Ambulatory\Ambulatory\Mail\InvitationEmail;

class Invitation extends AmbulatoryModel
{
    use HasUuid;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['token'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ambulatory_invitations';

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
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($invitation) {
            Mail::to($invitation->email)->send(new InvitationEmail($invitation));
        });
    }

    /**
     * Accept the invitation.
     *
     * @return mixed
     */
    public function accepted()
    {
        $credential = Str::random();

        tap($this->createNewUser($credential), function ($user) use ($credential) {
            Mail::to($user->email)->send(new CredentialEmail($credential));
        });
    }

    /**
     * Create a new user.
     *
     * @param string $credential
     * @return User
     */
    protected function createNewUser(string $credential)
    {
        return User::create([
            'id' => Str::uuid(),
            'name' => $this->email,
            'email' => $this->email,
            'password' => Hash::make($credential),
            'type' => $this->findUserType(),
        ]);
    }

    /**
     * Get the user type.
     */
    protected function findUserType()
    {
        if ($this->role === 'admin') {
            return User::ADMIN;
        }

        return User::DOCTOR;
    }
}
