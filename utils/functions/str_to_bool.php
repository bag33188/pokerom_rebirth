<?php

if (!function_exists('str_to_bool')) {
    /**
     * Convert string boolean value to boolean
     *
     * @param string|null $value
     * @return bool
     */
    function str_to_bool(?string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOL);
    }
}
