<?php

namespace App\Factories;

use Illuminate\Http\UploadedFile;
use Jenssegers\Mongodb\Eloquent\Model;

interface FileHandlerFactory
{
    public function getFilename(): string;

    public function getFileDocument(): Model;

    public function upload(UploadedFile $file): void;

    public function download(string $fileId): void;

    public function destroy(Model $file): void;
}
