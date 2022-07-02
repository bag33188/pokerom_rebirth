<?php

namespace App\Services\GridFS;

use MongoDB\Client as MongoClient;
use MongoDB\Database;
use MongoDB\GridFS\Bucket;
use Utils\Classes\AbstractGridFSConnection as GridFSConnection;
use Utils\Modules\GridFsMethods;

class RomFilesGridFSConnection extends GridFSConnection
{
    protected string $bucketName;
    protected string $databaseName;
    protected int $chunkSize;

    /** @var Bucket GridFS bucket object */
    protected Bucket $bucket;

    public function __construct(string $databaseName, string $bucketName, int $chunkSize)
    {
        $this->databaseName = $databaseName;
        $this->bucketName = $bucketName;
        $this->chunkSize = $chunkSize;
        $this->setBucket();
    }

    protected function connectToMongoClient(): Database
    {
        $dsn = GridFsMethods::GFS_MONGO_URI();
        $db = new MongoClient($dsn);
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
