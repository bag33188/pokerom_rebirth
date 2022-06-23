<?php

namespace Utils\Modules\GridFS;

use Illuminate\Support\Facades\Config;
use MongoDB\Client as MongoClient;
use MongoDB\Database;
use MongoDB\GridFS\Bucket;
use Utils\Classes\AbstractGridFsDbConnection as GfsDatabaseConnection;

class Connection extends GfsDatabaseConnection
{
    public function __construct(string $databaseName = null)
    {
        self::$mongoConfig = Config::get(self::MONGO_CONF_PREFIX);
        self::$gfsConfig = Config::get(self::GFS_CONF_PREFIX);
        $this->setDatabaseValues($databaseName);
        $this->gfsBucket = $this->setGfsBucket();
    }

    private function setDatabaseValues(?string $databaseName): void
    {
        $this->bucketName = self::$gfsConfig['bucketName'];
        $this->databaseName = $databaseName ?? self::$mongoConfig['database'];
        $this->chunkSize = self::$gfsConfig['chunkSize'];
    }

    protected final static function GFS_MONGO_URI(): string
    {
        return '' .
            self::$gfsConfig['driver'] . '://' .
            self::$mongoConfig['username'] . ':' .
            self::$mongoConfig['password'] . '@' .
            self::$mongoConfig['host'] . ':' .
            self::$mongoConfig['port'] . '/?authMechanism=' .
            self::$mongoConfig['auth']['mechanism'] . '&authSource=' .
            self::$mongoConfig['auth']['source'];
    }

    protected final function connectToMongoClient(): Database
    {
        $dsn = self::GFS_MONGO_URI();
        $db = new MongoClient($dsn);
        return $db->selectDatabase($this->databaseName);
    }

    protected final function setGfsBucket(): Bucket
    {
        $mongodb = $this->connectToMongoClient();
        return $mongodb->selectGridFSBucket([
            'chunkSizeBytes' => $this->chunkSize,
            'bucketName' => $this->bucketName
        ]);
    }
}
