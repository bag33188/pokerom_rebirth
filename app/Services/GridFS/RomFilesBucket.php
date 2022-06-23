<?php

namespace App\Services\GridFS;

use App\Models\File;
use FileRepo;
use Illuminate\Http\UploadedFile;
use Jenssegers\Mongodb\Eloquent\Model;
use Utils\Classes\AbstractGridFsBucket as GfsBucket;
use Utils\Modules\FileFactory\FileDownloader;

class RomFilesBucket extends GfsBucket
{
    protected const DOWNLOAD_CHUNK_SIZE = 0xFF000;

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getFileExt(): string
    {
        return explode('.', $this->filename, 2)[1];
    }

    public function getFileDocument(): File
    {
        return FileRepo::getFileByFilename($this->filename);
    }

    public function upload(UploadedFile $file): void
    {
        $this->setUploadFileData($file);
        $this->uploadFileFromStream();
    }

    public function download(string $fileId): void
    {
        $stream = $this->createDownloadStreamFromFile($fileId);
        $fileDownloader = new FileDownloader($stream, self::DOWNLOAD_CHUNK_SIZE);
        $fileDownloader->downloadFile();
    }

    public function destroy(Model $file): void
    {
        $this->deleteFileFromBucket($file->getKey());
    }
}
