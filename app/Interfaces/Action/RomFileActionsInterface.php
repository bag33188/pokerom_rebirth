<?php

namespace App\Interfaces\Action;

interface RomFileActionsInterface
{
    /** @return string[] */
    public function listStorageRomFiles(): array;

    /** @return string[] */
    public function listRomFiles(): array;
}
