<?php
use Illuminate\Database\Eloquent\Model;

if (!function_exists('normalizeObjectFromStdClassOrArray')) {
    /**
     * Takes an stdClass or array input and always outputs and stdClass.
     *
     * Useful for livewire pages that are constantly updating data/server-side state
     *
     * @param stdClass|array $object
     * @return void
     */
    function normalizeObjectFromStdClassOrArray(stdClass|array|Model &$object): void
    {
        $object = json_decode(json_encode($object), associative: false);
    }
}
