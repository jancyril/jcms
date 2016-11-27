<?php

namespace Janitor\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function setSlugAttribute(string $slug)
    {
        $this->attributes['slug'] = str_slug($slug);
    }
}
