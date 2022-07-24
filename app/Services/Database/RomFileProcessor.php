<?php

namespace App\Services\Database;

use GridFS\Support\GridFSProcessor;

class RomFileProcessor extends GridFSProcessor
{
    protected string $entityName = 'rom_files.processor';

    /**
     * Create new GridFS Processor Instance
     *
     * @param RomFilesConnection $romFilesConnection
     */
    public function __construct(RomFilesConnection $romFilesConnection)
    {
        $this->gridFilesUploadPath = storage_path('app/rom_files');
        parent::__construct($romFilesConnection);
    }
}
