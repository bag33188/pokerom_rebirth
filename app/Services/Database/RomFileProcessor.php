<?php

namespace App\Services\Database;

use GridFS\Support\GridFSProcessor;

class RomFileProcessor extends GridFSProcessor
{
    protected string $entityName = 'rom_files.processor';
    protected string $storageUploadPath = 'app/rom_files';

    /**
     * Create new GridFS Processor Instance
     *
     * @param RomFilesConnection $romFilesConnection
     */
    public function __construct(RomFilesConnection $romFilesConnection)
    {
        parent::__construct($romFilesConnection);
    }
}
