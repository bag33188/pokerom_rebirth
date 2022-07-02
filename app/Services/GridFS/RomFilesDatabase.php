<?php

namespace App\Services\GridFS;

use Config;
use Utils\Classes\AbstractGridFSDatabase;

class RomFilesDatabase extends AbstractGridFSDatabase
{
    public readonly string $bucketName;
    public readonly string $databaseName;
    public readonly int $chunkSize;

    public function __construct()
    {
        $this->databaseName = Config::get('gridfs.connection.database');
        $this->bucketName = Config::get('gridfs.bucketName');
        $this->chunkSize = Config::get('gridfs.chunkSize');
    }

    public final static function getMongoURI(): string
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
}
