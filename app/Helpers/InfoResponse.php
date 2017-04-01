<?php

namespace Janitor\Helpers;

use Illuminate\Http\Response;

class InfoResponse extends Response
{
    public function __construct(string $message, array $data, int $status = 200, array $headers = [])
    {
        $content = [
            'result' => true,
            'type' => 'info',
            'title' => 'Heads up',
            'message' => $message,
        ];

        $content = empty($data) ? $content : array_merge($content, $data);

        parent::__construct($content, $status, $headers);
    }
}
