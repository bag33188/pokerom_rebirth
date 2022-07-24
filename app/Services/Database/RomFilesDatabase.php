<?php

namespace App\Services\Database;

use GridFS\Client\AbstractGridFSDatabase as GridFSDatabase;

class RomFilesDatabase extends GridFSDatabase
{
    protected string $entityName = 'pokerom_files.db';

    protected bool $useAuth = true;

    protected string $databaseName = 'pokerom_files';
    protected string $bucketName = 'rom';
    protected int $chunkSize = 0xFF000;

    /**
     * Create new GridFS Database Instance
     */
    public function __construct()
    {
        parent::__construct();
    }
}
