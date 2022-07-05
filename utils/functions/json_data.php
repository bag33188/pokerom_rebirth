<?php

use Illuminate\Http\JsonResponse;
use Utils\Classes\JsonDataResponse;

if (!function_exists('jsonData')) {
    /**
     * Use this function to return a new {@see JsonDataResponse} object for use with methods
     * that do not explicitly return a resource and/or collection
     * (or that don't use a {@see \App\Providers\DataServiceProvider DataServiceProvider} method)
     *
     * @param array $data
     * @param int $code
     * @param array $headers
     * @return JsonResponse
     */
    function jsonData(array $data, int $code, array $headers = []): JsonResponse
    {
        // (new JsonDataResponse($data, $code, $headers))();
        $response = new JsonDataResponse($data, $code, $headers);
        return $response();
    }
}
