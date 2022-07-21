<?php

namespace App\Interfaces\Service;

use App\Models\RomFile;

interface RomFileServiceInterface
{
    public function downloadRomFile(RomFile $romFile): RomFile;

    public function uploadRomFile(string $romFilename): RomFile;

    public function deleteRomFile(RomFile $romFile): RomFile;
}
