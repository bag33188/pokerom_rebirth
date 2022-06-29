<?php

namespace Utils\Modules\GridFS;

use Config;
use MongoDB\BSON\ObjectId;

class FileBucket extends Connection
{
    protected string $filename;
    protected string $filepath;

    /**
     * Converts ObjectID string to BSON ObjectID
     *
     * @param string $fileId
     * @return ObjectId
     */
    protected final static function parseObjectId(string $fileId): ObjectId
    {
        return new ObjectId($fileId);
    }

    protected function uploadFileFromStream(): void
    {
        $stream = fopen($this->filepath, 'rb');
        $this->gfsBucket->uploadFromStream($this->filename, $stream);
        fclose($stream);
    }

    /**
     * @param string $fileId
     * @return resource
     */
    protected function createDownloadStreamFromFile(string $fileId)
    {
        return $this->gfsBucket->openDownloadStream(self::parseObjectId($fileId));
    }

    protected function deleteFileFromBucket(string $fileId): void
    {
        $this->gfsBucket->delete(self::parseObjectId($fileId));
    }


    protected function setUploadFileData(string $fileName): void
    {
        self::normalizeFileName($fileName);
        $this->filename = $fileName;
        $this->filepath = sprintf("%s/%s", Config::get('gridfs.fileUploadPath'), $fileName);
    }

    private static function normalizeFileName(string &$filename): void
    {
        // explode function's limit param can be used to check for single occurrence of the `.` (period) character
        [$name, $ext] = explode('.', $filename, 2);
        $name = trim($name);
        $ext = strtolower($ext);
        $filename = "$name.$ext";
    }
}
