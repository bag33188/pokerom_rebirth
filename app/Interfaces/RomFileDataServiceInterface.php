<?php

namespace App\Interfaces;

use App\Models\RomFile;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Classes\JsonDataResponse;

interface RomFileDataServiceInterface
{
    public function downloadFile(RomFile $file): StreamedResponse;

    public function uploadFile(string $filename): JsonDataResponse;

    public function deleteFile(RomFile $file): JsonDataResponse;
}
