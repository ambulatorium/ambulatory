<?php

namespace Reliqui\Ambulatory;

use Illuminate\Contracts\Auth\Authenticatable;

class User extends AmbulatoryModel implements Authenticatable
{
    const ADMIN = 3;
    const DOCTOR = 2;
    const PATIENT = 1;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'integer',
    ];

    /**
     * Type of user.
     *
     * @return int
     */
    public function type()
    {
        return (int) $this->type;
    }

    /**
     * Type of user is a doctor.
     *
     * @return bool
     */
    public function isDoctor()
    {
        return $this->type() === self::DOCTOR;
    }

    /**
     * Type of user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type() === self::ADMIN;
    }

    /**
     * Type of user is patient.
     *
     * @return bool
     */
    public function isPatient()
    {
        return $this->type() === self::PATIENT;
    }

    /**
     * The user is a verified doctor.
     *
     * @return bool
     */
    public function isVerifiedDoctor()
    {
        return $this->doctorProfile != null;
    }

    /**
     * Doctors' profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function doctorProfile()
    {
        return $this->hasOne(Doctor::class, 'user_id');
    }

    /**
     * Get the user medical forms.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicalForms()
    {
        return $this->hasMany(MedicalForm::class, 'user_id');
    }

    /**
     * Get all the appointments for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function appointments()
    {
        return $this->hasManyThrough(Booking::class, MedicalForm::class);
    }

    /**
     * Get all appointments to user inbox.
     *
     * @return mixed
     */
    public function inbox()
    {
        if ($this->isDoctor()) {
            return $this->doctorProfile->appointments();
        }

        return $this->appointments();
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

        return 'patient';
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
