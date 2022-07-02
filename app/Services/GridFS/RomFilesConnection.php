<?php

namespace App\Services\GridFS;

use MongoDB\Client as MongoClient;
use MongoDB\Database;
use MongoDB\GridFS\Bucket;
use Utils\Classes\AbstractGridFSConnection;

class RomFilesConnection extends AbstractGridFSConnection
{
    protected string $bucketName;
    protected string $databaseName;
    protected int $chunkSize;
    protected string $dsn;

    /** @var Bucket GridFS bucket object */
    protected Bucket $bucket;

    public function __construct(RomFilesDatabase $romFilesConnection)
    {
        $this->databaseName = $romFilesConnection->databaseName;
        $this->bucketName = $romFilesConnection->bucketName;
        $this->chunkSize = $romFilesConnection->chunkSize;
        $this->dsn = RomFilesDatabase::getMongoURI();
        $this->setBucket();
    }

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
