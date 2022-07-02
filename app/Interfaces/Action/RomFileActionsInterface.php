<?php

namespace App\Interfaces\Action;

interface RomFileActionsInterface
{
    /** @return string[] */
    public function listStorageFiles(): array;

    /** @return string[] */
    public function listRomFiles(): array;
}
