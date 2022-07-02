<?php

namespace App\Interfaces\Service;

use App\Models\RomFile;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Modules\JsonDataResponse;

interface RomFileDataServiceInterface
{
    public function downloadFile(RomFile $romFile): StreamedResponse;

    public function uploadFile(string $filename): JsonDataResponse;

    public function deleteFile(RomFile $romFile): JsonDataResponse;
}
