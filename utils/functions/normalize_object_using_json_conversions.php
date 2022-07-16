<?php

if (!function_exists('normalizeObjectUsingJSONConversions')) {
    /**
     * Takes a class object (or eloquent object) or associative array and normalizes it using {@see json_encode} and then {@see json_decode}
     *
     * @param mixed $object `stdClass`, `array`, collections, models are all types that can be handled
     * @param bool $associative Set to true to convert object to an associative {@see array array}, else use {@see stdClass stdClass} as conversion
     * @return void
     *
     */
    function normalizeObjectUsingJSONConversions(mixed &$object, bool $associative = false): void
    {
        $object = json_decode(json_encode($object), associative: $associative);
    }
}
