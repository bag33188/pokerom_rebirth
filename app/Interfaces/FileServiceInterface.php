<?php

namespace App\Interfaces;

use App\Models\File;
use App\Services\JsonServiceResponse;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileServiceInterface
{
    public function downloadFile(File $file): StreamedResponse;

    public function uploadFile(UploadedFile $file): JsonServiceResponse;

    public function deleteFile(File $file): JsonServiceResponse;
}
