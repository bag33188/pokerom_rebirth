<?php

namespace App\Interfaces;

use App\Models\File;
use Classes\JsonDataServiceResponse;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileServiceInterface
{
    public function downloadFile(File $file): StreamedResponse;

    public function uploadFile(UploadedFile $file): JsonDataServiceResponse;

    public function deleteFile(File $file): JsonDataServiceResponse;
}
