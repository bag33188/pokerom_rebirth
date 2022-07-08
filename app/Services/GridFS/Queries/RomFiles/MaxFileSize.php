<?php

namespace App\Services\GridFS\Queries\RomFiles;

use App\Models\RomFile;

trait MaxFileSize
{
    protected function romFileWithGreatestFileSize(): int
    {
        return RomFile::max('length');
    }
}
