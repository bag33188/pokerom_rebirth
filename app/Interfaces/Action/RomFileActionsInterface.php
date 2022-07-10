<?php

namespace App\Interfaces\Action;

interface RomFileActionsInterface
{
    /** @return string[] */
    public function listAllFilesInStorage(): array;

    /** @return string[] */
    public function listRomFilesInStorage(): array;

    /** @return string[] */
    public function listRomFilesInStorageSorted(): array;
}
