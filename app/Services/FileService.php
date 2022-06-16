<?php

namespace App\Services;

use App\Interfaces\FileServiceInterface;
use App\Models\File;
use Illuminate\Http\UploadedFile;
use JetBrains\PhpStorm\ArrayShape;
use Modules\FileDownloader;
use Modules\FileHandler;

class FileService implements FileServiceInterface
{
    public function downloadFile(string $fileId)
    {
        $gridfs = new FileHandler();
        $stream = $gridfs->getDownloadStreamFromFile($fileId);
        $fileDownloader = new FileDownloader($stream, 0xFF000);
        $fileDownloader->downloadFile();
    }

    #[ArrayShape(['message' => "string"])]
    public function uploadFile(UploadedFile $file): array
    {
        $gridfs = new FileHandler();
        $gridfs->setUploadFileData($file);
        $gridfs->uploadFileFromStream();
        return ['message' => "file {$gridfs->getFilename()} created!"];
    }

    #[ArrayShape(['message' => "string"])]
    public function deleteFileFromBucket(string $fileId, File $file): array
    {
        $gridfs = new FileHandler();
        $gridfs->deleteFileFromBucket($fileId);
        event('eloquent.deleted: App\Models\File', $file);
        return ['message' => "{$file['filename']} deleted!"];
    }
}
