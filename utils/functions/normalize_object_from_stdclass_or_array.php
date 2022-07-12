<?php

use Illuminate\Database\{Eloquent\Collection as EloquentCollection, Eloquent\Model as EloquentModel};
use Jenssegers\Mongodb\Eloquent\Model as MongoDbModel;

if (!function_exists('normalizeObjectFromStdClassOrArray')) {
    /**
     * Takes an stdClass or array input and always outputs and stdClass.
     *
     * Useful for livewire pages that are constantly updating data/server-side state
     *
     * @param stdClass|array|EloquentModel|EloquentCollection|MongoDbModel $object
     * @param bool $associative
     * @return void
     */
    function normalizeObjectFromStdClassOrArray(stdClass|array|EloquentModel|EloquentCollection|MongoDbModel &$object, bool $associative = false): void
    {
        $object = json_decode(json_encode($object), associative: $associative);
    }
}
