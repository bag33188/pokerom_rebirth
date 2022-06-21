<?php

namespace App\Services;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;

class JsonServiceResponse implements Jsonable
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

    public function toJson($options = 0): bool|string
    {
       return json_encode($this->json);
    }

    public function response(): JsonResponse
    {
        return response($this->toJson(), $this->code);
    }
}
