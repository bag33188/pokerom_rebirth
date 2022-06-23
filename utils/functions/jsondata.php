<?php

use Illuminate\Http\JsonResponse;
use Utils\Modules\JsonDataResponse;

if (!function_exists('jsondata')) {
    function jsondata(array $data, int $code, array $headers = []): JsonResponse
    {
        // (new JsonDataResponse($data, $code, $headers))();
        $response = new JsonDataResponse($data, $code, $headers);
        return $response();
    }
}
