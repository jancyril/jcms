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
        return auth()->check();
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
            'status' => [
                'required',
            ],
        ];
    }

    public function put()
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
            'status' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'The category field is required.',
            'category_id.integer' => 'The category field must be an integer.',
        ];
    }
}
