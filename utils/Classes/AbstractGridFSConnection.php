<?php

namespace Utils\Classes;

use MongoDB\Client as MongoClient;
use MongoDB\Database;
use MongoDB\GridFS\Bucket;

abstract class AbstractGridFSConnection
{
    protected string $bucketName;
    protected string $databaseName;
    protected int $chunkSize;
    protected string $dsn;
    protected Bucket $bucket;

    public function __construct()
    {
        $this->setConnectionValues();
    }

    /**
     * Set all connection values (`bucketName`, `chunkSize`, `databaseName`, `dsn`, `$this->setBucket()`)
     *
     * _Call in constructor_
     *
     * @return void
     */
    abstract protected function setConnectionValues(): void;

    protected function connectToMongoClient(): Database
    {
        $db = new MongoClient($this->dsn);
        return $db->selectDatabase($this->databaseName);
    }

    protected function setBucket(): void
    {
        $mongodb = $this->connectToMongoClient();
        $this->bucket = $mongodb->selectGridFSBucket([
            'chunkSizeBytes' => $this->chunkSize,
            'bucketName' => $this->bucketName
        ]);
    }

    public function getBucket(): Bucket
    {
        return $this->bucket;
    }
}
