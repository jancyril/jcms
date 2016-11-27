<?php

namespace Janitor\Http\Requests\Admin;

use Janitor\Http\Requests\Request;

class PostCategory extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() ?? false;
    }

    /**
     * Validation rules for post method
     *
     * @return array
     */
    protected function post()
    {
        return [
            'name' => [
                'required',
                'unique:post_categories,name'
            ]
        ];
    }

    /**
     * Validation rules for put method
     *
     * @return array
     */
    protected function put()
    {
        return [
            'name' => [
                'required',
                'unique:post_categories,name,'.intval($this->segment(3))
            ]
        ];
    }
}
