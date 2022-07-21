<?php

namespace App\Services\Database;

use GridFS\Client\AbstractGridFSDatabase as GridFSDatabase;

class RomFilesDatabase extends GridFSDatabase
{
    protected string $entityName = 'rom_files';

    protected bool $useAuth = true;

    /**
     * Create new GridFS Database Instance
     */
    public function __construct()
    {
        parent::__construct();
    }
}
