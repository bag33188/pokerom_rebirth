<?php

use Illuminate\Http\JsonResponse;
use Utils\Classes\JsonDataResponse;

if (!function_exists('jsondata')) {
    function jsondata(array $data, int $code, array $headers = []): JsonResponse
    {
        $response = new JsonDataResponse($data, $code, $headers);
        return $response();
    }
}
