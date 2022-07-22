<?php

namespace GridFS\Support;

use GridFS\Client\AbstractGridFSConnection;
use GridFS\GridFS;
use MongoDB\BSON\ObjectId;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Utils\Modules\FileDownloader;

class GridFSProcessor extends GridFS implements GridFSProcessorInterface
{
    protected static string $gridFilesUploadPath;

    public function __construct(private readonly AbstractGridFSConnection $gridFSConnection)
    {
        if (empty(self::$gridFilesUploadPath)) {
            self::$gridFilesUploadPath = config('gridfs.fileUploadPath');
        }

        $this->setGridFSEntities();
    }

    private function setGridFSEntities(): void
    {
        $this->bucketName = $this->gridFSConnection->get_bucket_name();
        $this->chunkSize = $this->gridFSConnection->get_chunk_size();
        $this->databaseName = $this->gridFSConnection->get_database_name();
    }

    public final function upload(string $filename): void
    {
        self::appendUploadPathToFilename($filename);
        $originalFileName = self::getFileOriginalName($filename);
        $this->throwExceptionIfFileDoesNotExistInAppStorage(filepath: $filename);
        $stream = fopen($filename, 'rb', true);
        $this->gridFSConnection->bucket->uploadFromStream($originalFileName, $stream);
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

    private static function appendUploadPathToFilename(string &$filename): void
    {
        $storagePath = self::$gridFilesUploadPath;
        $filename = "$storagePath/$filename";
    }

    private static function parseUploadPath(): string|array|null
    {
        $backSlashPattern = /** @lang RegExp */
            "/\x{5C}/u";
        return preg_replace($backSlashPattern, "/", self::$gridFilesUploadPath);
    }

    private static function parseStoragePath(): array|string|null
    {
        $_DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
        return str_replace($_DOCUMENT_ROOT, '', self::parseUploadPath());
    }

    private static function getFileOriginalName(string $filename): string|array
    {
        $storagePath = self::$gridFilesUploadPath;
        return str_replace("${storagePath}/", "", $filename);
    }

    /**
     * @param string $filepath
     * @return void
     * @throws NotFoundHttpException
     */
    private function throwExceptionIfFileDoesNotExistInAppStorage(string $filepath): void
    {
        if (!file_exists($filepath)) {
            throw new NotFoundHttpException(
                message: sprintf(
                    "Error: File `%s` does not exist on server's disk storage. Storage Path: %s",
                    self::getFileOriginalName($filepath),
                    self::parseStoragePath()
                )
            );
        }
    }

    protected function fileIsTooBig(string $filename): bool
    {
        $seven_gibibytes = pow(2, 30) * 7;
        if (filesize($filename) >= $seven_gibibytes) {
            // do something for OVERLY large files??
            return true;
        }
        return false;
    }
}
