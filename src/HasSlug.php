<?php

namespace Ambulatory;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot up the trait.
     */
    public static function bootHasSlug()
    {
        static::saving(function ($model) {
            $model->addSlug();
        });
    }

    /**
     * Add slug to the model.
     */
    protected function addSlug()
    {
        $slugSource = $this->generateSlugFrom();

        $slug = $this->generateUniqueSlug($slugSource);

        $this->slug = $slug;
    }

    /**
     * Generate slug from slug fields.
     *
     * @return string
     */
    protected function generateSlugFrom()
    {
        $slugFields = static::$slugFieldsFrom;

        $slugSource = collect($slugFields)
            ->map(function (string $fieldName) {
                return data_get($this, $fieldName, '');
            })
            ->implode('-');

        return substr($slugSource, 0, 100);
    }

    /**
     * Generate unique slug.
     *
     * @param string $value
     * @return string
     */
    protected function generateUniqueSlug(string $value)
    {
        $slug = $originalSlug = Str::slug($value);
        $i = 0;

        while ($this->slugExists($slug, $this->exists ? $this->id : null)) {
            $slug = $originalSlug.'-'.$i++;
        }

        return $slug;
    }

    /**
     * Find slug.
     *
     * @param string $slug
     * @param string $ignoreId
     * @return bool
     */
    protected function slugExists(string $slug, string $ignoreId = null)
    {
        $query = $this->where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}
