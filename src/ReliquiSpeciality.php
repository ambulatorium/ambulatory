<?php

namespace Reliqui\Ambulatory;

class ReliquiSpeciality extends ReliquiModel
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
    protected $table = 'reliqui_specialities';

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
     * The doctors that has the speciality.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function doctors()
    {
        return $this->belongsToMany(ReliquiDoctor::class, 'reliqui_doctors_specialities', 'speciality_id', 'doctor_id');
    }

    /**
     * boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($item) {
            $item->doctors()->detach();
        });
    }
}