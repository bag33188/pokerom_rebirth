<?php

namespace Modules;

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

    private const MONGO_CONF_PREFIX = 'gridfs';

    public function __construct(string $databaseName = null)
    {
        self::$mongoConfig = Config::get(self::MONGO_CONF_PREFIX);
        $this->setDatabaseValues($databaseName);
        $this->gfsBucket = $this->setGfsBucket();
    }

    private function setDatabaseValues(string $databaseName): void
    {
        $this->bucketName = self::$mongoConfig['bucketName'];
        $this->databaseName = $databaseName ?: self::$mongoConfig['connection']['database'];
        $this->chunkSize = (int)hexdec(self::$mongoConfig['chunkSize']);
    }

    private static function GFS_MONGO_URI(): string
    {
        return '' .
            self::$mongoConfig['driver'] . '://' .
            self::$mongoConfig['connection']['username'] . ':' .
            self::$mongoConfig['connection']['password'] . '@' .
            self::$mongoConfig['connection']['host'] . ':' .
            self::$mongoConfig['connection']['port'] . '/?authMechanism=' .
            self::$mongoConfig['connection']['auth']['mechanism'] . '&authSource=' .
            self::$mongoConfig['connection']['auth']['source'];
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
