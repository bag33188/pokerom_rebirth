<?php

namespace App\Actions;

use App\Interfaces\Action\RomFileActionsInterface;
use Storage;

class RomFileActions implements RomFileActionsInterface
{
    /**
     * @return array|string[]
     */
    public function listStorageRomFiles(): array
    {
        return Storage::disk(ROM_FILES_DIRNAME)->files('/');
    }

    /**
     * @return array|string[]
     */
    public function listRomFiles(): array
    {
        return array_filter($this->listStorageRomFiles(), function ($var) {
            return preg_match(ROM_FILENAME_PATTERN, $var);
        });
    }
}
