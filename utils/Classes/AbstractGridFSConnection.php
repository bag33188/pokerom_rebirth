<?php

namespace Utils\Classes;

use MongoDB\Database;
use MongoDB\GridFS\Bucket;

abstract class AbstractGridFSConnection
{
    protected string $bucketName;
    protected string $databaseName;
    protected int $chunkSize;
    protected string $dsn;
    protected Bucket $bucket;

    /**
     * Connect to MongoDB Client
     *
     * @return Database
     */
    abstract protected function connectToMongoClient(): Database;

    /**
     * Set GridFS {@see Bucket Bucket} object.
     *
     * @return void
     */
    abstract protected function setBucket(): void;

    /**
     * Get GridFS {@see Bucket Bucket} object.
     *
     * @return Bucket
     */
    abstract public function getBucket(): Bucket;
}
