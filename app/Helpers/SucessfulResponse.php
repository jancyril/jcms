<?php

namespace Janitor\Helpers;

use Illuminate\Http\Response;

class SucessfulResponse extends Response
{
    public function __construct(string $message, array $data = [], int $status = 200, array $headers = [])
    {
        $content = [
            'result' => true,
            'type' => 'success',
            'title' => 'Success',
            'message' => $message,
        ];

        $content = empty($data) ? $content : array_merge($content, $data);

        parent::__construct($content, $status, $headers);
    }
}
