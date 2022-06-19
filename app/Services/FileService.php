<?php

namespace App\Services;

use App\Events\FileDeleted;
use App\Events\FileUploaded;
use App\Interfaces\FileServiceInterface;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use JetBrains\PhpStorm\ArrayShape;
use App\Modules\FileDownloader;
use App\Modules\FileHandler;

class FileService implements FileServiceInterface
{
    public function downloadFile(string $fileId)
    {
        $gridfs = new FileHandler();
        $gridfs->download($fileId);
    }

    #[ArrayShape(['message' => "string"])]
    public function uploadFile(UploadedFile $file): array
    {
        $gridfs = new FileHandler();
        $gridfs->upload($file);
        event(new FileUploaded($gridfs->getFileDocument()));
        return ['message' => "file {$gridfs->getFilename()} created!"];
    }

    #[ArrayShape(['message' => "string"])]
    public function deleteFile(File $file): array
    {
        $fileId = $file->getKey();
        event(new FileDeleted($file));
        $gridfs = new FileHandler();
        $gridfs->deleteFileFromBucket($fileId);
        return ['message' => "{$file['filename']} deleted!"];
    }
}
