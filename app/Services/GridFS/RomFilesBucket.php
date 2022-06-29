<?php

namespace App\Services\GridFS;

use App\Models\RomFile;
use Jenssegers\Mongodb\Eloquent\Model;
use RomFileRepo;
use Utils\Modules\FileFactory\FileDownloader;
use Utils\Modules\GridFS\AbstractGridFsBucket as GfsBucket;

class RomFilesBucket extends GfsBucket
{
    // override default download chunk size
    protected const DOWNLOAD_CHUNK_SIZE = 0xFF000;

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getFileExt(): string
    {
        return explode('.', $this->filename, 2)[1];
    }

    public function getFileDocument(): RomFile
    {
        return RomFileRepo::getFileByFilename($this->filename);
    }

    public function upload(string $filename): void
    {
        $this->setUploadFileData($filename);
        $this->uploadFileFromStream();
    }

    public function download(string $fileId): void
    {
        $stream = $this->createDownloadStreamFromFile($fileId);
        $fileDownloader = new FileDownloader($stream, self::DOWNLOAD_CHUNK_SIZE);
        $fileDownloader->downloadFile();
    }

    public function delete(Model $file): void
    {
        // use the getKey method for indexing since file is a generic abstract class
        $this->deleteFileFromBucket($file->getKey());
    }
}
