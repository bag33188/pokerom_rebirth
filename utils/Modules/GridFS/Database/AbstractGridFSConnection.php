<?php

namespace Utils\Modules\GridFS\Database;

use MongoDB\Client as MongoClient;
use MongoDB\Database;
use MongoDB\GridFS\Bucket;
use Utils\Modules\GridFS\GridFS;
use Utils\Modules\GridFS\Support\GridFSBucketMethods;

/**
 * GridFS Connection Class for connection to a GridFS MongoDB Database
 *
 * _Constructor can accept a {@see AbstractGridFSDatabase GridFSDatabase} Object_
 */
abstract class AbstractGridFSConnection extends GridFS
{
    public readonly string $bucketName;

    public readonly string $databaseName;

    public readonly int $chunkSize;

    /** @var string mongodb connection string */
    protected readonly string $dsn;

    /** @var Bucket gridfs bucket object */
    private Bucket $bucket;

    public function __construct()
    {
        $this->setConnectionValues();
        $this->selectFileBucket();
    }

    /**
     * Set all connection values
     *  + {@see bucketName bucketName}
     *  + {@see chunkSize chunkSize}
     *  + {@see databaseName databaseName}
     *  + {@see dsn dsn}, see {@see AbstractGridFSDatabase::mongoURI MongoURI}
     *
     * @link https://www.mongodb.com/docs/manual/reference/connection-string/
     *
     * @return void
     */
    abstract protected function setConnectionValues(): void;

    private function connectToMongoClient(): Database
    {
        $db = new MongoClient($this->dsn);
        return $db->selectDatabase($this->databaseName);
    }

    private function selectFileBucket(): void
    {
        $mongodb = $this->connectToMongoClient();
        $this->bucket = $mongodb->selectGridFSBucket([
            'chunkSizeBytes' => $this->chunkSize,
            'bucketName' => $this->bucketName
        ]);
    }

    public final function actions(): GridFSBucketMethods
    {
        return new GridFSBucketMethods($this->bucket);
    }
}