<?php

namespace Janitor\Http\Requests\Admin;

use Janitor\Http\Requests\Request;

class Post extends Request
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

    public function post()
    {
        return [
            'title' => [
                'required',
            ],
            'content' => [
                'required',
            ],
            'category_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
