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

    public static function getGfsUploadFilepath()
    {
        return Config::get('gridfs.fileUploadPath');
    }
}
