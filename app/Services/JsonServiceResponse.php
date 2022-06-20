<?php

namespace App\Services;

class JsonServiceResponse
{
    public readonly array $json;
    public readonly int $code;

    public function __construct(array $json, int $code)
    {
        $json['success'] = $code < 400;
        $this->json = $json;
        $this->code = $code;
    }
}
