<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Interfaces\FileRepositoryInterface;
use App\Models\File;
use App\Models\Rom;
use Illuminate\Http\UploadedFile;
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

    public function uploadFile(UploadedFile $file)
    {
        $gridfs = new FileHandler();
        $gridfs->setUploadFileData($file);
        $gridfs->uploadFileFromStream();
        return ['message' => "file {$gridfs->getFilename()} created!"];
    }

    public function deleteFileFromBucket(string $fileId, File $file)
    {
        $gridfs = new FileHandler();
        $gridfs->deleteFileFromBucket($fileId);
        event('eloquent.deleted: App\Models\File', $file);
        return ['message' => "{$file['filename']} deleted!"];
    }

    /**
     * @throws NotFoundException
     */
    public function showRom($file): Rom
    {
        $rom = $file->rom()->first();
        return $rom ?? throw new NotFoundException('no rom is associated with this file');
    }
}
