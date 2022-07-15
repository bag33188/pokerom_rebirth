<?php

if (!function_exists('normalizeClassObject')) {
    /**
     * Takes an stdClass, array, or Eloquent data type input and converts object to an {@see stdClass} or {@see array}.
     *
     * Useful for livewire pages that are constantly updating data/server-side state
     *
     * @param mixed $object `stdClass`, `array`, collections, models are all types that can be handled
     * @param bool $associative Set to true to convert to assoc {@see array array}, else use {@see stdClass stdClass} as conversion
     * @return void
     */
    function normalizeClassObject(mixed &$object, bool $associative = false): void
    {
        $object = json_decode(json_encode($object), associative: $associative);
    }
}
