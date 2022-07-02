<?php

namespace App\Services\GridFS;

use Utils\Classes\AbstractGridFSDatabase;
use Utils\Modules\MongoMethods;

class RomFilesDatabase extends AbstractGridFSDatabase
{
    public readonly string $bucketName;
    public readonly string $databaseName;
    public readonly int $chunkSize;

    public function __construct()
    {
        $gfsConf = MongoMethods::getGfsConfig();
        $this->databaseName = $gfsConf['connection']['database'];
        $this->bucketName = $gfsConf['bucketName'];
        $this->chunkSize = $gfsConf['chunkSize'];
    }

    public final static function getMongoURI(): string
    {
        $mongoConfig = MongoMethods::getMongoConfig();
        return '' .
            $mongoConfig['driver'] . '://' .
            $mongoConfig['username'] . ':' .
            $mongoConfig['password'] . '@' .
            $mongoConfig['host'] . ':' .
            $mongoConfig['port'] . '/?authMechanism=' .
            $mongoConfig['options']['authMechanism'] . '&authSource=' .
            $mongoConfig['options']['authSource'];
    }
}
