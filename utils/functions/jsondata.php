<?php

use Illuminate\Http\JsonResponse;
use Utils\Modules\JsonDataResponse;

if (!function_exists('jsondata')) {
    /**
     * @param array $data
     * @param int $code
     * @param array $headers
     * @return JsonResponse
     */
    function jsondata(array $data, int $code, array $headers = []): JsonResponse
    {
        // (new JsonDataResponse($data, $code, $headers))();
        $response = new JsonDataResponse($data, $code, $headers);
        return $response();
    }
}
