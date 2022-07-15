<?php

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Jenssegers\Mongodb\Eloquent\Model as MongoDbModel;

if (!function_exists('normalizeClassObject')) {
    /**
     * Takes an stdClass, array, or Eloquent data type input and converts object to an {@see stdClass} or {@see array}.
     *
     * Useful for livewire pages that are constantly updating data/server-side state
     *
     * @param stdClass|array|EloquentModel|EloquentCollection|MongoDbModel $object
     * @param bool $associative Set to true to convert to assoc {@see array array}, else use {@see stdClass stdClass} as conversion
     * @return void
     */
    function normalizeClassObject(stdClass|array|EloquentModel|EloquentCollection|MongoDbModel &$object, bool $associative = false): void
    {
        $object = json_decode(json_encode($object), associative: $associative);
    }
}
