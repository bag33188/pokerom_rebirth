<?php

namespace GridFS\Client;

use GridFS\GridFS;
use GridFS\Support\FileDownloader;
use GridFS\Support\FilenameHandler;
use MongoDB\BSON\ObjectId;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GridFSProcessor extends GridFS implements GridFSProcessorInterface
{
    protected string $storagePath;

    public function __construct(private readonly AbstractGridFSConnection $gridFSConnection)
    {
        $this->setGridFSEntities();
    }

    private function setGridFSEntities(): void
    {
        $this->bucketName = $this->gridFSConnection->bucketName;
        $this->chunkSize = $this->gridFSConnection->chunkSize;
        $this->databaseName = $this->gridFSConnection->databaseName;
    }

    public final function upload(string $filename): void
    {
        $filenameUtil = new FilenameHandler($filename);
        $filepath = $filenameUtil->makeFilepathFromFilename();
        if (!file_exists($filepath)) {
            $backSlashPattern = /** @lang RegExp */
                "/\x{5C}/u";
            $storagePath = preg_replace($backSlashPattern, "/", $this->storagePath);
            throw new BadRequestHttpException(
                sprintf("File `${filename}` does not exist on server's disk storage. Path: %s", $storagePath)
            );
        }
        $stream = fopen($filepath, 'rb');
        $this->gridFSConnection->bucket->uploadFromStream($filename, $stream);
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
