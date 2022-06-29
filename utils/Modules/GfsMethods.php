<?php

namespace Utils\Modules;

use Illuminate\Support\Facades\Config;
use MongoDB\BSON\ObjectId;

class GfsMethods
{
    public static function normalizeFileName(string &$filename): void
    {
        // explode function's limit param can be used to check for single occurrence of the `.` (period) character
        [$name, $ext] = explode('.', $filename, 2);
        $name = trim($name);
        $ext = strtolower($ext);
        $filename = "$name.$ext";
    }

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

    public static function makeFilepathFromFilename(string $filename): string
    {
        return sprintf("%s/%s", Config::get('gridfs.fileUploadPath'), $filename);
    }
}
