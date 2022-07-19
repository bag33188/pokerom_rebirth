<?php

namespace App\Actions;

use App\Interfaces\Action\RomFileActionsInterface;
use Storage;

class RomFileActions implements RomFileActionsInterface
{
    /**
     * @return array|string[]
     */
    public function listAllFilesInStorage(): array
    {
        return Storage::disk(ROM_FILES_DIRNAME)->files('/');
    }

    /**
     * @return array|string[]
     */
    public function listRomFilesInStorage(): array
    {
        $filteredRomFiles = array_filter(
            $this->listAllFilesInStorage(),
            fn(string $romFilename): false|int => preg_match(ROM_FILENAME_PATTERN, $romFilename)
        );
        return array_values($filteredRomFiles);
    }

    /**
     * Sort by string length descending
     *
     * @return array|string[]
     */
    public function listRomFilesInStorageSorted(): array
    {
        $romFilesList = $this->listRomFilesInStorage();
        usort($romFilesList, fn(string $a, string $b): int => strlen($b) - strlen($a));
        return $romFilesList;
    }
}
