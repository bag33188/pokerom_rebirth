<?php

namespace Utils\Modules\GridFS\Support;

use MongoDB\BSON\ObjectId;
use MongoDB\GridFS\Bucket;
use Utils\Classes\FileMethods;
use Utils\Modules\Download\FileDownloader;
use Utils\Modules\GridFS\GridFS;

class GridFSBucketMethods extends GridFS implements GridFSBucketMethodsInterface
{
    private readonly Bucket $bucket;

    public function __construct(Bucket $bucket)
    {
        $this->bucket = $bucket;
    }

    public final function upload(string $filename): void
    {
        $stream = fopen(FileMethods::makeFilepathFromFilename($filename), 'rb');
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
