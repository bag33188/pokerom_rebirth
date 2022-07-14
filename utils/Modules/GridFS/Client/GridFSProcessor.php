<?php

namespace GridFS\Client;

use GridFS\GridFS;
use GridFS\Support\FileDownloader;
use GridFS\Support\FilenameHandler;
use MongoDB\BSON\ObjectId;

class GridFSProcessor extends GridFS implements GridFSProcessorInterface
{
    public function __construct(private readonly AbstractGridFSConnection $gridFSConnection)
    {
        $this->bucketName = $this->gridFSConnection->bucketName;
        $this->chunkSize = $this->gridFSConnection->chunkSize;
        $this->databaseName = $this->gridFSConnection->databaseName;
    }

    public final function upload(string $filename): void
    {
        $fileUtil = new FilenameHandler($filename);
        $fileUtil->normalizeFileName();
        $filepath = $fileUtil->makeFilepathFromFilename();
        $stream = fopen($filepath, 'rb');
        $this->gridFSConnection->bucket->uploadFromStream($fileUtil->filename, $stream);
        fclose($stream);
    }

    public final function download(ObjectId $fileId): void
    {
        $stream = $this->gridFSConnection->bucket->openDownloadStream($fileId);
        $downloader = new FileDownloader($stream, CONTENT_TRANSFER_SIZE);
        $downloader->downloadFile();
    }

    public final function delete(ObjectId $fileId): void
    {
        $this->gridFSConnection->bucket->delete($fileId);
    }
}
