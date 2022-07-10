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

    /**
     * @return array|string[]
     */
    public function listRomFilesSorted(): array
    {
        $romFilesList = $this->listRomFiles();
        usort($romFilesList, fn(string $a, string $b): int => strlen($b) - strlen($a));
        return $romFilesList;
    }
}
