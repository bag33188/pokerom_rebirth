<?php

namespace GridFS\Client;

use GridFS\GridFS;
use GridFS\Support\FileDownloader;
use GridFS\Support\FilenameHandler;
use MongoDB\BSON\ObjectId;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GridFSProcessor extends GridFS implements GridFSProcessorInterface
{
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
        $this->throwExceptionIfFileDoesNotExistInDiskStorage($filepath, $filename);
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

    private function parseStoragePath(): string
    {
        $backSlashPattern = /** @lang RegExp */
            "/\x{5C}/u";
        return (string)preg_replace($backSlashPattern, "/", config('gridfs.fileUploadPath'));
    }

    private function throwExceptionIfFileDoesNotExistInDiskStorage(string $filepath, string $filename): void
    {
        if (!file_exists($filepath)) {
            throw new BadRequestHttpException(
                message: sprintf(
                    "Error: File `%s` does not exist on server's disk storage. Storage Path: %s",
                    $filename, $this->parseStoragePath()
                )
            );
        }
    }
}
