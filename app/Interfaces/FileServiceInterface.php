<?php

namespace App\Interfaces;

use App\Models\File;
use Illuminate\Http\UploadedFile;

interface FileServiceInterface{
    public function downloadFile(string $fileId);
    public function uploadFile(UploadedFile $file);
    public function deleteFileFromBucket(string $fileId, File $file);
}
