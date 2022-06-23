<?php

namespace Utils\Modules\GridFS;

use Illuminate\Http\UploadedFile;
use MongoDB\BSON\ObjectId;
use Utils\Modules\FileFactory\FileInfoResolver;

class FileBucket extends Connection
{
    protected string $filename;
    protected string $filepath;
    protected const DOWNLOAD_CHUNK_SIZE = 0x3FC00;

    protected final static function parseObjectId(string $fileId): ObjectId
    {
        return new ObjectId($fileId);
    }

    protected function uploadFileFromStream(): void
    {
        $stream = fopen($this->filepath, 'rb');
        $this->gfsBucket->uploadFromStream($this->filename, $stream);
    }

    protected function createDownloadStreamFromFile(string $fileId)
    {
        return $this->gfsBucket->openDownloadStream(self::parseObjectId($fileId));
    }

    protected function deleteFileFromBucket(string $fileId): void
    {
        $this->gfsBucket->delete(self::parseObjectId($fileId));
    }

    /**
     * Sets all needed file information for uploading to database
     *
     * @param UploadedFile $file
     * @return void
     */
    protected function setUploadFileData(UploadedFile $file): void
    {
        $fileInfo = new FileInfoResolver($file);
        $this->filename = $fileInfo->getFilename();
        $this->filepath = $fileInfo->getFilePath();
    }
}
