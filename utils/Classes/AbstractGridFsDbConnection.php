<?php

namespace Utils\Classes;

use MongoDB\{Database, GridFS\Bucket};

abstract class AbstractGridFsDbConnection
{
    protected string $bucketName;
    protected string $databaseName;
    protected int $chunkSize;
    protected Bucket $gfsBucket;
    protected static array $mongoConfig;
    protected static array $gfsConfig;

    protected final const GFS_CONF_PREFIX = 'gridfs';
    protected final const MONGO_CONF_PREFIX = 'gridfs.connection';

    abstract protected function connectToMongoClient(): Database;

    abstract protected function setGfsBucket(): Bucket;

    abstract protected static function GFS_MONGO_URI(): string;
}
