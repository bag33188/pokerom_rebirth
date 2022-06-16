<?php

namespace App\Repositories;

use App\Interfaces\FileRepositoryInterface;
use Modules\FileDownloader;
use Modules\FileHandler;

class FileRepository implements FileRepositoryInterface {
    public function downloadFile($fileId) {
        $gridfs = new FileHandler();
        $stream = $gridfs->getDownloadStreamFromFile($fileId);
        $fileDownloader = new FileDownloader($stream, 0xFF000);
        $fileDownloader->downloadFile();
    }
    public function uploadFile($file){
        $gridfs = new FileHandler();

        $gridfs->setUploadFileData($file);
        $gridfs->uploadFileFromStream();
        return ['message' => "file {$gridfs->getFilename()} created!"];
    }
    public function deleteFile($fileId,$file){
        $gridfs = new FileHandler();
        $gridfs->deleteFileFromBucket($fileId);
        event('eloquent.deleted: App\Models\File', $file);
        return ['message' => "{$file['filename']} deleted!"];
    }
}
