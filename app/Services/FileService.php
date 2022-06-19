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
        return ['message' => "file '" . GridFS::getFilename() . "' created!"];
    }

    #[ArrayShape(['message' => "string"])]
    public function deleteFile(File $file): array
    {
        event(new FileDeleted($file));
        GridFS::destroy($file->getKey());
        return ['message' => "{$file['filename']} deleted!"];
    }
}
