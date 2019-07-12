<?php

namespace Ambulatory;

class Specialization extends AmbulatoryModel
{
    use HasUuid, HasSlug;

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
    protected $table = 'ambulatory_specializations';

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
     * Get the fields for generating the slug.
     *
     * @var array
     */
    protected static $slugFieldsFrom = ['name'];

    /**
     * The doctors that has the specializations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'ambulatory_doctors_specializations', 'specialization_id', 'doctor_id');
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
