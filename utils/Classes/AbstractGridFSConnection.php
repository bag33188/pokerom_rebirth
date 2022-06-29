<?php

namespace Utils\Classes;

use MongoDB\Database;
use MongoDB\GridFS\Bucket;

abstract class AbstractGridFSConnection
{
    protected string $bucketName;
    protected string $databaseName;
    protected int $chunkSize;
    protected Bucket $bucket;

    abstract protected function connectToMongoClient(): Database;

    abstract protected function setBucket(): void;

    abstract protected function selectBucket(): Bucket;

    abstract public function getBucket(): Bucket;
}
