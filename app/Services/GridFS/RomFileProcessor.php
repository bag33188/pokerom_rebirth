<?php

namespace App\Services\GridFS;

use GfsRomFile;
use Utils\Modules\GridFS\Support\GridFSBucketMethods;

class RomFileProcessor extends GridFSBucketMethods
{
    protected string $entityName = 'rom_files.processor';

    public function __construct()
    {
        parent::__construct(GfsRomFile::getBucket());
    }
}
