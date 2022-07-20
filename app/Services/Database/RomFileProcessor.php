<?php

namespace App\Services\Database;

use GridFS\Client\GridFSProcessor;

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
        parent::__construct($romFilesConnection);
    }
}
