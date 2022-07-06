<?php

namespace Utils\Modules\GridFS\Client;

use Utils\Classes\_Static\MongoMethods;
use Utils\Modules\GridFS\GridFS;

/**
 * GridFS Database Class for defining a MongoDB Database
 */
abstract class AbstractGridFSDatabase extends GridFS
{
    public string $databaseName;
    public string $bucketName;
    public int $chunkSize;
    protected bool $useAuth = false;

    public function __construct(string $databaseName = null, string $bucketName = null, int $chunkSize = null)
    {
        $gfsConfig = MongoMethods::getGridFSConfig();
        if (empty($this->databaseName)) {
            $this->databaseName = $databaseName ?? $gfsConfig['connection']['database'];
        }
        if (empty($this->bucketName)) {
            $this->bucketName = $bucketName ?? $gfsConfig['bucketName'];
        }
        if (empty($this->chunkSize)) {
            $this->chunkSize = $chunkSize ?? $gfsConfig['chunkSize'];
        }
    }

    public function mongoURI(): string
    {
        $mongoConfig = MongoMethods::getMongoConfig();

        if ($this->useAuth === true) {
            return '' .
                $mongoConfig['driver'] . '://' .
                $mongoConfig['username'] . ':' .
                $mongoConfig['password'] . '@' .
                $mongoConfig['host'] . ':' .
                $mongoConfig['port'] . '/?authMechanism=' .
                $mongoConfig['options']['authMechanism'] . '&authSource=' .
                $mongoConfig['options']['authSource'];
        } else {
            return '' .
                $mongoConfig['driver'] . '://' .
                $mongoConfig['username'] . ':' .
                $mongoConfig['password'] . '@' .
                $mongoConfig['host'] . ':' .
                $mongoConfig['port'] . '/';
        }
    }
}
