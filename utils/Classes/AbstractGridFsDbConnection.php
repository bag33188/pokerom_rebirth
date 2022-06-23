<?php

namespace Utils\Classes;

use MongoDB\Database;
use MongoDB\GridFS\Bucket;

abstract class AbstractGridFsDbConnection
{
    protected string $bucketName;
    protected string $databaseName;
    protected int $chunkSize;
    protected Bucket $gfsBucket;

    abstract protected function connectToMongoClient(): Database;

    abstract protected function setGfsBucket(): Bucket;

    abstract protected static function GFS_MONGO_URI(): string;
}
