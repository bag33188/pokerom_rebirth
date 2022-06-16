<?php

namespace App\Interfaces;

use App\Models\File;
use Illuminate\Http\UploadedFile;

interface FileRepositoryInterface
{
    public function showAssociatedRom(string $fileId);
}
