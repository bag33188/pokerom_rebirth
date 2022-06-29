<?php

namespace App\Actions;

use Storage;

class RomFileActions
{
    public function listStorageFiles(): array
    {
        return Storage::disk(ROM_FILES_DIRNAME)->files('/');
    }
}
