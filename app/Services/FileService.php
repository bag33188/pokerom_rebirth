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
    private FileHandler $gridfs;
    public function __construct()
    {
        $this->gridfs = app(FileHandler::class);
    }

    public function downloadFile(string $fileId)
    {
        $this->gridfs->download($fileId);
    }

    #[ArrayShape(['message' => "string"])]
    public function uploadFile(UploadedFile $file): array
    {
        $this->gridfs->upload($file);
        event(new FileUploaded($this->gridfs->getFileDocument()));
        return ['message' => "file {$this->gridfs->getFilename()} created!"];
    }

    #[ArrayShape(['message' => "string"])]
    public function deleteFile(File $file): array
    {
        $fileId = $file->getKey();
        event(new FileDeleted($file));
        $this->gridfs->deleteFileFromBucket($fileId);
        return ['message' => "{$file['filename']} deleted!"];
    }
}
