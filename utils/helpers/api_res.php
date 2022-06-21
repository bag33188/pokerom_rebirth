<?php

function api_res(array $data, bool $success = true)
{
    return [...$data, 'success' => $success];
}
