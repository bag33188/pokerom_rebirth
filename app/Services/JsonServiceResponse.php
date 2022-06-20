<?php

namespace App\Services;

class JsonServiceResponse
{
    public readonly array $json;
    public readonly int $code;

    public function __construct(array $json, int $code)
    {
        self::setSuccessState($json, $code);
        $this->json = $json;
        $this->code = $code;
    }

    private static function setSuccessState(array &$object, int $statusCode): void
    {
        $object['success'] = $statusCode < 400 && $statusCode >= 200;
    }
}
