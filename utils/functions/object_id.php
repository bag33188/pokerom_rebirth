<?php

use MongoDB\BSON\ObjectId;

if (!function_exists('objectId')) {
    function objectId(string $_id): ObjectId
    {
        return new ObjectId($_id);
    }
}
