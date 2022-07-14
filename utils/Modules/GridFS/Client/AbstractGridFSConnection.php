<?php

namespace GridFS\Client;

use GridFS\GridFS;
use MongoDB\Client as MongoClient;
use MongoDB\Database;
use MongoDB\GridFS\Bucket;

/**
 * GridFS Connection Class for connection to a GridFS MongoDB Database
 *
 * _Constructor requires a {@see AbstractGridFSDatabase GridFSDatabase} Object_
 */
abstract class AbstractGridFSConnection extends GridFS
{
    /** @var string {@link https://www.mongodb.com/docs/manual/reference/connection-string/ MongoDB Connection String} */
    private readonly string $dsn;

    /** @var Bucket gridfs bucket object */
    public readonly Bucket $bucket;

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
}
