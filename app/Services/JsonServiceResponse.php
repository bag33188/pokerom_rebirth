<?php

namespace App\Services;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;

class JsonServiceResponse implements Jsonable
{
    public readonly array $data;
    public readonly int $code;

    public function __construct(array $data, int $code)
    {
        self::setSuccessState($data, $code);
        $this->$data = $data;
        $this->code = $code;
    }

    private static function setSuccessState(array &$data, int $statusCode): void
    {
        $data['success'] = $statusCode < 400 && $statusCode >= 200;
    }

    public function toJson($options = 0): bool|string
    {
        return json_encode($this->data);
    }

    public function response(): JsonResponse
    {
        return response()->json($this->data, $this->code);
    }
}
