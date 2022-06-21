<?php

use Illuminate\Database\Eloquent\Model;

function api_res(mixed $data, bool $success = true): array
{
    if ($data instanceof Model) {
        return ['data' => $data, 'success' => $success];
    } else {
        return [...$data, 'success' => $success];
    }
}
