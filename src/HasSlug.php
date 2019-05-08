<?php

namespace Reliqui\Ambulatory;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Set slug for the model.
     *
     * @param string $slug
     * @return void
     */
    public function setSlugAttribute(string $slug)
    {
        $this->attributes['slug'] = $this->addUniqueSlug($slug);
    }

    /**
     * Add unique slug.
     *
     * @param string $value
     * @return string
     */
    private function addUniqueSlug(string $value)
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
    private function slugExists(string $slug, string $ignoreId = null)
    {
        $query = $this->where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}
