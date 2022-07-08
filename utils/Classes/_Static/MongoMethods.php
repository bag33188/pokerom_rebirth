<?php

namespace Utils\Classes\_Static;

use MongoDB\BSON\ObjectId;

/**
 * This class contains a few helpful methods when interacting with MongoDB objects or using MongoDB logic.
 */
class MongoMethods
{
    /**
     * Converts a MongoDB ID string into a {@see ObjectId BSON Object ID}
     *
     * @param string $fileId
     * @return ObjectId
     */
    public static function parseObjectId(string $fileId): ObjectId
    {
        return new ObjectId($fileId);
    }

    /**
     * Retrieves MongoDB config array with values
     *
     * @return array
     */
    public static function getMongoConfig(): array
    {
        return config('database.connections.mongodb');
    }

    /**
     * Retrieves GridFS config array with values
     *
     * @return array
     */
    public static function getGridFSConfig(): array
    {
        return config('gridfs');
    }
}
