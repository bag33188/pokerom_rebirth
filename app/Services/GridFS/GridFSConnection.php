<?php

namespace App\Services\GridFS;

use MongoDB\Client as MongoClient;
use MongoDB\Database;
use MongoDB\GridFS\Bucket;
use Utils\Modules\GridFsMethods;

class GridFSConnection
{
    protected string $bucketName;
    protected string $databaseName;
    protected int $chunkSize;
    /** @var Bucket GridFS bucket object */
    protected Bucket $gfsBucket;

    public function __construct(string $databaseName, string $bucketName, int $chunkSize)
    {

        $this->databaseName = $databaseName;
        $this->bucketName = $bucketName;
        $this->chunkSize = $chunkSize;
        $this->setGfsBucket();

    }


    private function connectToMongoClient(): Database
    {
        $dsn = GridFsMethods::GFS_MONGO_URI();
        $db = new MongoClient($dsn);
        return $db->selectDatabase($this->databaseName);
    }

    private function setGfsBucket(): void
    {
        $mongodb = $this->connectToMongoClient();
        $this->gfsBucket = $mongodb->selectGridFSBucket([
            'chunkSizeBytes' => $this->chunkSize,
            'bucketName' => $this->bucketName
        ]);
    }

    public function getBucket(): Bucket
    {
        return $this->gfsBucket;
    }
}
