<?php

namespace App\Services;

use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\FileServiceInterface;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use JetBrains\PhpStorm\ArrayShape;
use FileHandler;

class FileService implements FileServiceInterface
{
    public function downloadFile(string $fileId)
    {
        FileHandler::download($fileId);
    }

    #[ArrayShape(['message' => "string"])]
    public function uploadFile(UploadedFile $file): array
    {
        FileHandler::upload($file);
        event(new FileUploaded(FileHandler::getFileDocument()));
        return ['message' => "file {FileHandler::getFilename()} created!"];
    }

    #[ArrayShape(['message' => "string"])]
    public function deleteFile(File $file): array
    {
        $fileId = $file->getKey();
        event(new FileDeleted($file));
        FileHandler::deleteFileFromBucket($fileId);
        return ['message' => "{$file['filename']} deleted!"];
    }
}
