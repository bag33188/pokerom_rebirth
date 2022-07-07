<?php

namespace App\Services\GridFS;

use Utils\Modules\GridFS\Client\AbstractGridFSDatabase as GridFSDatabase;

class RomFilesDatabase extends GridFSDatabase
{
    protected string $name = 'rom_files';
    protected bool $useAuth = true;

    /**
     * Create new GridFS Database Instance
     */
    public function __construct()
    {
        parent::__construct();
    }
}
