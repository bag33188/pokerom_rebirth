<?php

namespace Utils\Modules\GridFS\Support;

use MongoDB\BSON\ObjectId;
use MongoDB\GridFS\Bucket;
use Utils\Classes\_Static\FileMethods as FileUtil;
use Utils\Modules\FileDownloader;
use Utils\Modules\GridFS\GridFS;

class GridFSProcessor extends GridFS implements GridFSProcessorInterface
{
    private readonly Bucket $bucket;

    /**
     * @param Bucket $bucket GridFS Bucket Object
     */
    public function __construct(Bucket $bucket)
    {
        $this->bucket = $bucket;
    }

    public final function upload(string $filename): void
    {
        $filepath = FileUtil::makeFilepathFromFilename($filename);
        $stream = fopen($filepath, 'rb');
        $this->bucket->uploadFromStream($filename, $stream);
        fclose($stream);
    }

    public final function download(ObjectId $fileId, int $downloadTransferSize): void
    {
        $stream = $this->bucket->openDownloadStream($fileId);
        $downloader = new FileDownloader($stream, $downloadTransferSize);
        $downloader->downloadFile();
    }

    public final function delete(ObjectId $fileId): void
    {
        $this->bucket->delete($fileId);
    }
}
