<?php

namespace App\Services\GridFS;

use Utils\Classes\MongoMethods;
use Utils\Modules\GridFS\AbstractGridFSDatabase as GridFSDatabase;

class RomFilesDatabase extends GridFSDatabase
{
    public readonly string $bucketName;
    public readonly string $databaseName;
    public readonly int $chunkSize;

    protected function setDatabaseProperties(): void
    {
        $gfsConfig = MongoMethods::getGridFSConfig();

        $this->databaseName = $gfsConfig['connection']['database'];
        $this->bucketName = $gfsConfig['bucketName'];
        $this->chunkSize = $gfsConfig['chunkSize'];
    }

    public final static function mongoURI(): string
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
