<?php

use JetBrains\PhpStorm\ArrayShape;

#[ArrayShape([0 => "array", 'success' => "bool"])]
function api_res(array $data, bool $success = true): array
{
    return [...$data, 'success' => $success];
}
