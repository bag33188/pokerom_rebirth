<?php

if (!function_exists('normalizeObjectUsingJSONConversions')) {
    /**
     * Takes a class object ({@see stdClass stdClass}) or associative array ({@see array array})
     * and normalizes it using {@see json_encode} and then {@see json_decode}
     *
     * This method also works with **Eloquent Objects** (_resources/collections/models_).
     *
     * @param mixed $object stdClass, array, collections/resources, models are all types that can be handled
     * @param bool $normalizeToAssociativeArray Set to true to convert object to an associative {@see array}, else convert to {@see stdClass}
     * @return void
     *
     */
    function normalizeObjectUsingJSONConversions(mixed &$object, bool $normalizeToAssociativeArray = true): void
    {
        $object = json_decode(json_encode($object), associative: $normalizeToAssociativeArray);
    }
}
