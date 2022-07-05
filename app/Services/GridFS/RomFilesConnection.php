<?php

namespace App\Services\GridFS;

use Utils\Modules\GridFS\AbstractGridFSConnection as GridFSConnection;

class RomFilesConnection extends GridFSConnection
{
    public readonly string $bucketName;
    public readonly string $databaseName;
    public readonly int $chunkSize;
    protected readonly string $dsn;

    public function __construct(private readonly RomFilesDatabase $romFilesDatabase)
    {
        parent::__construct();
    }

    protected function setConnectionValues(): void
    {
        $this->databaseName = $this->romFilesDatabase->databaseName;
        $this->bucketName = $this->romFilesDatabase->bucketName;
        $this->chunkSize = $this->romFilesDatabase->chunkSize;
        $this->dsn = RomFilesDatabase::mongoURI();
    }
}
