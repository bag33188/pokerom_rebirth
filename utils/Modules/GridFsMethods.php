<?php

namespace Utils\Modules;

use Config;
use MongoDB\BSON\ObjectId;

class GridFsMethods
{
    public static function parseObjectId(string $fileId): ObjectId
    {
        return new ObjectId($fileId);
    }

    public static function GFS_MONGO_URI(): string
    {
        $mongoConfig = Config::get('gridfs.connection');
        $gfsConfig = Config::get('gridfs');
        return '' .
            $gfsConfig['driver'] . '://' .
            $mongoConfig['username'] . ':' .
            $mongoConfig['password'] . '@' .
            $mongoConfig['host'] . ':' .
            $mongoConfig['port'] . '/?authMechanism=' .
            $mongoConfig['auth']['mechanism'] . '&authSource=' .
            $mongoConfig['auth']['source'];
    }

    public static function getGfsUploadFilepath()
    {
        return Config::get('gridfs.fileUploadPath');
    }

}
