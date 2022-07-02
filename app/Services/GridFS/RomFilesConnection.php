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

    private RomFilesDatabase $romFilesDatabase;

    /** @var Bucket GridFS bucket object */
    protected Bucket $bucket;

    public function __construct(RomFilesDatabase $romFilesDatabase)
    {
        $this->romFilesDatabase = $romFilesDatabase;

        parent::__construct();
    }

    protected function setConnectionValues(): void
    {
        $this->databaseName = $this->romFilesDatabase->databaseName;
        $this->bucketName = $this->romFilesDatabase->bucketName;
        $this->chunkSize = $this->romFilesDatabase->chunkSize;
        $this->dsn = RomFilesDatabase::getMongoURI();
        $this->setBucket();
    }
}
