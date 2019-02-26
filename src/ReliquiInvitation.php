<?php

namespace Reliqui\Ambulatory;

use Illuminate\Support\Facades\Mail;
use Reliqui\Ambulatory\Mail\InvitationEmail;

class ReliquiInvitation extends ReliquiModel
{
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
    protected $table = 'reliqui_invitations';

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

        static::created(function ($invitation) {
            Mail::to($invitation->email)->send(new InvitationEmail($invitation));
        });
    }

    public function findUserType()
    {
        if ($this->role == 'admin') {
            return ReliquiUsers::ADMIN;
        }

        return ReliquiUsers::DOCTOR;
    }
}