<?php

namespace GridFS\Support;

use MongoDB\BSON\ObjectId;

/**
 * This class contains a few helpful methods when interacting with MongoDB objects or using MongoDB logic.
 */
class MongoUtils
{
    public final const MONGO_CONFIG_PATH = 'database.connections.mongodb';
    public final const GRIDFS_CONFIG_PATH = 'gridfs';

    /**
     * Converts a MongoDB ID string into a {@see ObjectId BSON Object ID}
     *
     * @param string $fileId
     * @return ObjectId
     */
    public static function parseStringAsBSONObjectId(string $fileId): ObjectId
    {
        return new ObjectId($fileId);
    }

    /**
     * Retrieves MongoDB config array with values
     *
     * @return array
     */
    public static function getMongoConfigArray(): array
    {
        return config(self::MONGO_CONFIG_PATH);
    }

    /**
     * Retrieves GridFS config array with values
     *
     * @return array
     */
    public static function getGridFSConfigArray(): array
    {
        return config(self::GRIDFS_CONFIG_PATH);
    }
}
