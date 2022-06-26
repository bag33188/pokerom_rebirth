<?php

namespace App\Interfaces;

use App\Models\RomFile;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Classes\JsonDataResponse;

interface RomFileDataServiceInterface
{
    public function downloadFile(RomFile $file): StreamedResponse;

    public function uploadFile(UploadedFile $file): JsonDataResponse;

    public function deleteFile(RomFile $file): JsonDataResponse;
}
