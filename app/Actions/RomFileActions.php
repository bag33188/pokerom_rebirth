<?php

namespace App\Actions;

use App\Interfaces\RomFileActionsInterface;
use Storage;

class RomFileActions implements RomFileActionsInterface
{
    public function listStorageFiles(): array
    {
        return Storage::disk(ROM_FILES_DIRNAME)->files('/');
    }

    public function listRomFiles(): array
    {
        return array_filter($this->listStorageFiles(), function ($var) {
            return preg_match(ROM_FILENAME_PATTERN, $var);
        });
    }
}
