<?php

namespace App\Services\GridFS\Queries\RomFiles;

use App\Models\RomFile;

trait MaxFileSize
{
    protected function largestRomFileLength(): int
    {
        return RomFile::max('length');
    }
}
