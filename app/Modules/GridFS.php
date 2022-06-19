<?php

namespace App\Modules;

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

    private const MONGO_CONF_PREFIX = 'database.connections.mongodb';

    public function __construct($databaseName = null, $bucketName = null, $chunkSize = null)
    {
        self::$mongoConfig = Config::get(self::MONGO_CONF_PREFIX);

        $this->setGridFSParams($databaseName, $bucketName, $chunkSize);
        $this->gfsBucket = $this->setGfsBucket();
    }

    private function setGridFSParams($databaseName, $bucketName, $chunkSize): void
    {
        $this->bucketName = $bucketName ?: self::$mongoConfig['gridfs']['bucketName'];
        $this->databaseName = $databaseName ?: self::$mongoConfig['database'];
        $this->chunkSize = $chunkSize ?: (int)hexdec(self::$mongoConfig['gridfs']['chunkSize']);
    }

    private static function GFS_MONGO_URI(): string
    {
        return '' .
            self::$mongoConfig['driver'] . '://' .
            self::$mongoConfig['username'] . ':' .
            self::$mongoConfig['password'] . '@' .
            self::$mongoConfig['host'] . ':' .
            self::$mongoConfig['port'] . '/?authMechanism=' .
            self::$mongoConfig['options']['authMechanism'] . '&authSource=' .
            self::$mongoConfig['options']['authSource'];
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
