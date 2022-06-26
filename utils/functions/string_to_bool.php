<?php

if (!function_exists('string_to_bool')) {
    /**
     * Convert string boolean value to boolean
     *
     * @param string $value
     * @return bool
     */
    function string_to_bool(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOL);
    }
}
