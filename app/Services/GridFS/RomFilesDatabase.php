<?php

namespace App\Services\GridFS;

use Utils\Classes\AbstractGridFSDatabase;
use Utils\Modules\MongoMethods;

class RomFilesDatabase extends AbstractGridFSDatabase
{
    public readonly string $bucketName;
    public readonly string $databaseName;
    public readonly int $chunkSize;

    protected function setDatabaseProperties(): void
    {
        $gfsConfig = MongoMethods::getGfsConfig();

        $this->databaseName = $gfsConfig['connection']['database'];
        $this->bucketName = $gfsConfig['bucketName'];
        $this->chunkSize = $gfsConfig['chunkSize'];
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
