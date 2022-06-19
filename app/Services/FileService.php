<?php

namespace App\Services;

use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\FileServiceInterface;
use App\Models\File;
use GridFS;
use Illuminate\Http\UploadedFile;
use JetBrains\PhpStorm\ArrayShape;

class FileService implements FileServiceInterface
{
    public function downloadFile(string $fileId)
    {
        GridFS::download($fileId);
    }

    #[ArrayShape(['message' => "string"])]
    public function uploadFile(UploadedFile $file): array
    {
        GridFS::upload($file);
        event(new FileUploaded(GridFS::getFileDocument()));
        $filename = GridFS::getFilename();
        return ['message' => "file {$filename} created!"];
    }

    #[ArrayShape(['message' => "string"])]
    public function deleteFile(File $file): array
    {
        $fileId = $file->getKey();
        event(new FileDeleted($file));
        GridFS::deleteFileFromBucket($fileId);
        return ['message' => "{$file['filename']} deleted!"];
    }
}
