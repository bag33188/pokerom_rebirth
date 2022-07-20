<?php

namespace GridFS\Support;

use GridFS\Client\AbstractGridFSConnection;
use GridFS\GridFS;
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
        $filepath = self::makeFilepathFromFilename($filename);
        $this->throwExceptionIfFileDoesNotExistInAppStorage($filename);
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

    private function parseStoragePath(): array|string|null
    {
        $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
        return str_replace($DOCUMENT_ROOT, config('app.url'), $this->parseDiskPath());
    }

    public function parseDiskPath(): string|array|null
    {
        $backSlashPattern = /** @lang RegExp */
            "/\x{5C}/u";
        return preg_replace($backSlashPattern, "/", config('gridfs.fileUploadPath'));
    }

    private function throwExceptionIfFileDoesNotExistInAppStorage(string $filename): void
    {
        if (!file_exists(self::makeFilepathFromFilename($filename))) {
            throw new BadRequestHttpException(
                message: sprintf(
                    "Error: File `%s` does not exist on server's disk storage. Storage Path: %s",
                    $filename,
                    $this->parseStoragePath()
                )
            );
        }
    }

    private static function makeFilepathFromFilename(string $filename): string
    {
        $storagePath = config('gridfs.fileUploadPath');
        return "$storagePath/${filename}";
    }
}
