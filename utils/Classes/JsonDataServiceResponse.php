<?php

namespace Utils\Classes;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;

class JsonDataServiceResponse implements Jsonable
{
    public readonly array $data;
    public readonly int $code;
    public readonly array $headers;

    public function __construct(array $data, int $code, array $headers = [])
    {
        self::setSuccessState($data, $code);
        $this->data = $data;
        $this->code = $code;
        $this->headers = $headers;
    }

    private static function setSuccessState(array &$data, int $statusCode): void
    {
        $data['success'] = $statusCode < 400 && $statusCode >= 200;
    }

    public function toJson($options = 0): bool|string
    {
        return json_encode($this->data);
    }

    public function renderResponse(): JsonResponse
    {
        return response()->json($this->data, $this->code, $this->headers);
    }
}
