<?php

namespace App\Services\Database\GridFS;

use GfsRomFile;
use GridFS\Support\GridFSProcessor;

class RomFileProcessor extends GridFSProcessor
{
    protected string $entityName = 'rom_files.processor';

    public function __construct()
    {
        parent::__construct(GfsRomFile::getBucket());
    }
}
