<?php

namespace App\Interfaces;

use App\Models\File;
use App\Modules\FileHandler;
use Illuminate\Http\UploadedFile;

interface FileServiceInterface
{
    public function downloadFile(string $fileId);

    public function uploadFile(UploadedFile $file);

    public function deleteFile(File $file);
}
