<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Interfaces\FileRepositoryInterface;
use App\Models\File;
use App\Models\Rom;
use Illuminate\Http\UploadedFile;
use JetBrains\PhpStorm\ArrayShape;
use Modules\FileDownloader;
use Modules\FileHandler;

class FileRepository implements FileRepositoryInterface
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

    /**
     * @throws NotFoundException
     */
    public function showAssociatedRom($file): Rom
    {
        $associatedRom = $file->rom()->first();
        return $associatedRom ?? throw new NotFoundException('no rom is associated with this file');
    }
}
