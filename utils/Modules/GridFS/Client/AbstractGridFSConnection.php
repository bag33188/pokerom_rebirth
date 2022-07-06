<?php

namespace Utils\Modules\GridFS\Client;

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
    protected string $databaseName;

    protected string $bucketName;

    protected int $chunkSize;

    private readonly string $dsn;

    /** @var Bucket gridfs bucket object */
    private Bucket $bucket;

    public function __construct(private readonly AbstractGridFSDatabase $gridFSDatabase)
    {
        $this->setConnectionValues();
        $this->selectFileBucket();
    }


    protected function setConnectionValues(): void
    {
        $this->databaseName = $this->gridFSDatabase->databaseName;
        $this->bucketName = $this->gridFSDatabase->bucketName;
        $this->chunkSize = $this->gridFSDatabase->chunkSize;
        $this->dsn = $this->gridFSDatabase->mongoURI();
    }

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
