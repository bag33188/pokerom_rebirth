<?php

if (!function_exists('string_to_bool')) {
    /**
     * @param string $value
     * @return bool
     */
    function string_to_bool(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOL);
    }
}
