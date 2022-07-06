<?php

namespace App\Services\GridFS\Queries\RomFiles;

use App\Models\RomFile;

trait TotalSizeBytes
{
    protected function sumLengthOfAllRomFilesBytes(): int
    {
        return RomFile::sum('length');
    }
}
