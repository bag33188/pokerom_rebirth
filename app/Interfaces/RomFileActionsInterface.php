<?php

namespace App\Interfaces;

interface RomFileActionsInterface
{
    /** @return string[] */
    public function listStorageFiles(): array;

    /** @return string[] */
    public function listRomFiles(): array;
}
