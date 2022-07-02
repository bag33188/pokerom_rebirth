<?php

namespace Utils\Classes;

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
    protected string $bucketName;
    /** @var string name of mongodb database */
    protected string $databaseName;
    /** @var int size to store chunked files as */
    protected int $chunkSize;
    /** @var string mongodb connection string */
    protected string $dsn;
    /** @var Bucket gridfs bucket object */
    protected Bucket $bucket;

    public function __construct()
    {
        $this->setConnectionValues();
        $this->setBucket();
    }

    /**
     * Set all connection values
     *  + {@link bucketName bucketName}
     *  + {@link chunkSize chunkSize}
     *  + {@link databaseName databaseName}
     *  + {@link dsn dsn}, see {@see AbstractGridFSDatabase::getMongoURI MongoURI}
     *
     * @return void
     */
    abstract protected function setConnectionValues(): void;

    protected final function connectToMongoClient(): Database
    {
        $db = new MongoClient($this->dsn);
        return $db->selectDatabase($this->databaseName);
    }

    protected final function setBucket(): void
    {
        $mongodb = $this->connectToMongoClient();
        $this->bucket = $mongodb->selectGridFSBucket([
            'chunkSizeBytes' => $this->chunkSize,
            'bucketName' => $this->bucketName
        ]);
    }

    public final function getBucket(): Bucket
    {
        return $this->bucket;
    }
}
