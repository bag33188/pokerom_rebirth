<?php

namespace App\Services\GridFS;

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

}
