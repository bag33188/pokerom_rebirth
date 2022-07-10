<?php

namespace App\Services\GridFS;

use GfsRomFile;
use Utils\Modules\GridFS\Support\GridFSProcessor;

class RomFileProcessor extends GridFSProcessor
{
    protected string $entityName = 'rom_files.processor';

    public function __construct()
    {
        parent::__construct(GfsRomFile::getBucket());
    }
}
