<?php

namespace App\Interfaces;

use App\Models\File;
use Illuminate\Http\UploadedFile;

interface FileServiceInterface
{
    public function downloadFile(string $fileId, string $filename);

    public function uploadFile(UploadedFile $file);

    public function deleteFile(File $file);
}
