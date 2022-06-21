<?php

use Illuminate\Database\Eloquent\Model;

if (!function_exists('api_res')) {
    function api_res(mixed $data, bool $responseIsSuccessful = true): array
    {
        if ($data instanceof Model) {
            return ['data' => $data, 'success' => $responseIsSuccessful];
        } else {
            return [...$data, 'success' => $responseIsSuccessful];
        }
    }
}
