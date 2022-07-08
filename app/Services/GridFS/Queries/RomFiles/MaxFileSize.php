<?php

namespace App\Services\GridFS\Queries\RomFiles;

use App\Models\RomFile;

trait MaxFileSize
{
    protected function romFileWithMaxFileSize(): mixed
    {
        return RomFile::max('length');
    }
}
