<?php

namespace Janitor\Traits;

trait Slugify
{
    /**
     * This method will try to generate a unique slug.
     *
     * @param string  $slug
     * @param numeric $id
     *
     * @return string
     */
    protected function slugify($slug, $id = '')
    {
        $slug = str_slug($slug);

        if ($id) {
            $record = self::where('slug', $slug)->oldest('id')->take(1)->get();

            if ($record->isEmpty()) {
                return $slug;
            }

            if ($record->first()->id == $id) {
                return $slug;
            }
        }

        $record = self::whereRaw("slug RLIKE '^{$slug}(-[0-9]*)?$'")
                        ->latest('slug')
                        ->first();

        if (!$record) {
            return $slug;
        }

        if ($record->id == $id) {
            return $this->similar($slug, $record->slug);
        }

        return $this->newSlug($slug, $record->slug);
    }

    /**
     * This method will check for changes in title of name.
     *
     * @param int    $id
     * @param string $value
     * @param string $field
     *
     * @return bool
     */
    protected function recordHasChanged($id, $value, $field = 'title')
    {
        $record = self::select($field)->find($id);

        return $record->$field == $value ? false : true;
    }

    /**
     * This will create a new slug based on the found record.
     *
     * @param string $suggested
     * @param string $found
     *
     * @return string
     */
    private function newSlug($suggested, $found)
    {
        $pieces = explode('-', $found);

        if (!is_numeric(end($pieces))) {
            return $suggested.'-1';
        }

        return $suggested.'-'.(end($pieces) + 1);
    }

    /**
     * Thi will check if the new slug and the existing slug is the same.
     *
     * @param string $slug
     * @param string $found
     *
     * @return string
     */
    private function similar($slug, $found)
    {
        if ($slug == $found) {
            return $slug;
        }
    }

    abstract protected function slugToUse($id);
}
