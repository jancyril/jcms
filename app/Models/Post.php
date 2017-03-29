<?php

namespace Janitor\Models;

use Janitor\Traits\Slugify;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Slugify;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content',
        'image', 'user_id', 'category_id',
    ];

    public function setSlugAttribute($slug)
    {
        $id = $this->attributes['id'] ?? '';

        if ($id != '') {
            $slug = $this->slugToUse($id);
        }

        $this->attributes['slug'] = $this->slugify($slug, $id);
    }

    public function slugToUse($id)
    {
        $title = $this->attributes['title'];
        $slug = $this->attributes['slug'];

        return $this->recordHasChanged($id, $title, 'title') ? $title : $slug;
    }
}
