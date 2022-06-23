<?php

namespace App\Services;

use App\Models\File;
use FileRepo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Utils\Modules\GridFS\GridFsFilesHandler as GfsFilesHandler;

class RomFilesHandler extends GfsFilesHandler
{
    protected const DOWNLOAD_CHUNK_SIZE = 0xFF000;

    public function __construct(string $databaseName = null)
    {
        self::$serverUploadFilePath = Config::get('gridfs.fileUploadPath');

        parent::__construct($databaseName);
    }

    public function getFilename(): string
    {
        return $this->filename;
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

    public function destroy(File $file): void
    {
        $this->deleteFileFromBucket($file->getKey());
    }
}