<?php

namespace Utils\Modules\GridFS;

use MongoDB\Client as MongoClient;
use MongoDB\Database;
use MongoDB\GridFS\Bucket;

/**
 * GridFS Connection Class for connection to a GridFS MongoDB Database
 *
 * _Constructor can accept a {@see AbstractGridFSDatabase GridFSDatabase} Object_
 */
abstract class AbstractGridFSConnection
{
    /** @var string name of gridfs bucket (default is `fs`) */
    protected readonly string $bucketName;

    /** @var string name of mongodb database */
    protected readonly string $databaseName;

    /** @var int size to store chunked files as */
    protected readonly int $chunkSize;

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
