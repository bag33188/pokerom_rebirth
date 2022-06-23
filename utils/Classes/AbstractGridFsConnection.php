<?php

namespace Utils\Classes;

use MongoDB\Database;
use MongoDB\GridFS\Bucket;

abstract class AbstractGridFsConnection
{
    protected string $bucketName;
    protected string $databaseName;
    protected int $chunkSize;
    protected Bucket $gfsBucket;

    abstract protected static function GFS_MONGO_URI(): string;

    abstract protected function connectToMongoClient(): Database;

    abstract protected function setGfsBucket(): Bucket;
}
