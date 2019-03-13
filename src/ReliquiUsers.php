<?php

namespace Reliqui\Ambulatory;

use Illuminate\Contracts\Auth\Authenticatable;

class ReliquiUsers extends ReliquiModel implements Authenticatable
{
    const DEFAULT = 1;
    const DOCTOR = 2;
    const ADMIN = 3;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['role'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reliqui_users';

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
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = 'remember_token';

    /**
     * Type of users.
     *
     * @return int
     */
    public function type()
    {
        return (int) $this->type;
    }

    /**
     * Type of users is a doctor.
     *
     * @return bool
     */
    public function isDoctor()
    {
        return $this->type() === self::DOCTOR;
    }

    /**
     * Type of users is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type() === self::ADMIN;
    }

    /**
     * Doctor's profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function doctor()
    {
        return $this->hasOne(ReliquiDoctor::class, 'user_id');
    }

    /**
     * Get the user medical form.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicalForm()
    {
        return $this->hasMany(ReliquiPatient::class, 'user_id');
    }

    /**
     * Get all user appointments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(ReliquiAppointment::class, 'user_id');
    }

    /**
     * Get all appointments that the user has access to.
     *
     * @return mixed
     */
    public function inbox()
    {
        return ReliquiAppointment::with('patient', 'scheduled.workLocation')
            ->when($this->isDoctor(), function ($query) {
                $query->whereHas('scheduled', function ($schedule) {
                    $schedule->where('doctor_id', $this->doctor->id);
                });
            })
            ->orWhereHas('patient', function ($query) {
                $query->whereUserId($this->id);
            })
            ->paginate(25);
    }

    /**
     * Get user role.
     *
     * @return string
     */
    public function getRoleAttribute()
    {
        if ($this->isAdmin()) {
            return $this->type = 'admin';
        }

        if ($this->isDoctor()) {
            return $this->type = 'doctor';
        }

        return 'default';
    }

    /**
     * Get the user avatar.
     *
     * @param  string  $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        return $value ?: 'https://secure.gravatar.com/avatar/'.md5(strtolower(trim($this->email))).'?s=80';
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->getKeyName();
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string|null
     */
    public function getRememberToken()
    {
        if (! empty($this->getRememberTokenName())) {
            return (string) $this->{$this->getRememberTokenName()};
        }
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        if (! empty($this->getRememberTokenName())) {
            $this->{$this->getRememberTokenName()} = $value;
        }
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }
}
