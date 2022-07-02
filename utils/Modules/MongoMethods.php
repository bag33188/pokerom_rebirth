<?php

namespace Utils\Modules;

use Config;
use MongoDB\BSON\ObjectId;

class MongoMethods
{
    public static function parseObjectId(string $fileId): ObjectId
    {
        return new ObjectId($fileId);
    }

    public static function getMongoConfig(): array
    {
        return Config::get('database.connections.mongodb');
    }

    public static function getGfsConfig(): array
    {
        return Config::get('gridfs');
    }
}
