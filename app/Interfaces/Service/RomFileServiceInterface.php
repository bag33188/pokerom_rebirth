<?php

namespace App\Interfaces\Service;

use App\Models\RomFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface RomFileServiceInterface
{
    public function downloadRomFile(RomFile $romFile): StreamedResponse;

    public function uploadRomFile(string $romFilename): RomFile;

    public function deleteRomFile(RomFile $romFile): RomFile;
}
