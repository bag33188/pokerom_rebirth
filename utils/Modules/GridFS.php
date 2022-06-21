<?php

namespace Utils\Modules;

use Illuminate\Support\Facades\Config;
use MongoDB\BSON\ObjectId;
use MongoDB\Client as MongoClient;
use MongoDB\Database;
use MongoDB\GridFS\Bucket;

class GridFS
{
    private string $bucketName;
    private string $databaseName;
    private int $chunkSize;
    protected Bucket $gfsBucket;
    private static array $mongoConfig;
    private static array $gfsConfig;

    private const GFS_CONF_PREFIX = 'gridfs';
    private const MONGO_CONF_PREFIX = 'gridfs.connection';

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
        $this->databaseName = $databaseName ?: self::$mongoConfig['database'];
        $this->chunkSize = self::$gfsConfig['chunkSize'];
    }

    private static function GFS_MONGO_URI(): string
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

    private function connectToMongoClient(): Database
    {
        $dsn = self::GFS_MONGO_URI();
        $db = new MongoClient($dsn);
        return $db->selectDatabase($this->databaseName);
    }

    private function setGfsBucket(): Bucket
    {
        $mongodb = $this->connectToMongoClient();
        return $mongodb->selectGridFSBucket([
            'chunkSizeBytes' => $this->chunkSize,
            'bucketName' => $this->bucketName
        ]);
    }

    protected final static function parseObjectId(string $id): ObjectId
    {
        return new ObjectId($id);
    }
}
