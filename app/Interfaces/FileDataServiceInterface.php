<?php

namespace App\Interfaces;

use App\Models\File;
use Utils\Classes\JsonDataServiceResponse;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileDataServiceInterface
{
    public function downloadFile(File $file): StreamedResponse;

    public function uploadFile(UploadedFile $file): JsonDataServiceResponse;

    public function deleteFile(File $file): JsonDataServiceResponse;
}
