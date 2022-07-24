<?php

namespace GridFS\Support;

use GridFS\Client\AbstractGridFSConnection;
use GridFS\GridFS;
use MongoDB\BSON\ObjectId;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Utils\Modules\FileDownloader;

class GridFSProcessor extends GridFS implements GridFSProcessorInterface
{
    private string $gridFilesStorageUploadPath;
    protected string $storageUploadPath;

    public function __construct(private readonly AbstractGridFSConnection $gridFSConnection)
    {
        if (empty($this->storageUploadPath)) {
            $this->gridFilesStorageUploadPath = config('gridfs.fileUploadPath');
        } else {
            $this->gridFilesStorageUploadPath = storage_path($this->storageUploadPath);
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
        $this->appendUploadPathToFilename($filename);
        $originalFileName = $this->getFileOriginalName($filename);
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

    private function appendUploadPathToFilename(string &$filename): void
    {
        $storagePath = $this->gridFilesStorageUploadPath;
        $filename = "$storagePath/$filename";
    }

    private function parseUploadPath(): string|array|null
    {
        $backSlashPattern = /** @lang RegExp */
            "/\x{5C}/u";
        return preg_replace($backSlashPattern, "/", $this->gridFilesStorageUploadPath);
    }

    private function parseStoragePath(): array|string|null
    {
        $_DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
        return str_replace($_DOCUMENT_ROOT, '', $this->parseUploadPath());
    }

    private function getFileOriginalName(string $filename): string|array
    {
        $storagePath = $this->gridFilesStorageUploadPath;
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
                    $this->getFileOriginalName($filepath),
                    $this->parseStoragePath()
                )
            );
        }
    }

    public static function fileIsTooBig(string $filename): bool
    {
        $seven_gibibytes = pow(2, 30) * 7;
        if (filesize($filename) >= $seven_gibibytes) {
            // do something for OVERLY large files??
            return true;
        }
        return false;
    }
}
