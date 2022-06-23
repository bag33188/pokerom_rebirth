<?php

namespace App\Interfaces;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Utils\Modules\JsonDataResponse;

interface FileDataServiceInterface
{
    public function downloadFile(File $file): StreamedResponse;

    public function uploadFile(UploadedFile $file): JsonDataResponse;

    public function deleteFile(File $file): JsonDataResponse;
}
