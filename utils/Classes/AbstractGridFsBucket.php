<?php

namespace Utils\Classes;

use Illuminate\Http\UploadedFile;
use MongoDB\BSON\ObjectId;
use Utils\Modules\GridFS\Connection;

abstract class AbstractGridFsBucket extends Connection
{
    protected UploadedFile $file;
    protected string $filename;
    protected string $filepath;

    /**
     * The path on the server to which the uploaded file should be retrieved from.
     * @var string
     */
    protected static string $serverUploadFilePath;

    /**
     * Opens a file stream from the defined filepath and
     * opens a mongodb gridfs upload stream using the file's name and
     * newly opened filestream.
     *
     * @return void
     *
     * @see \MongoDB\GridFS\Bucket uploadFromStream
     */
    abstract protected function uploadFileFromStream(): void;

    /**
     * Opens a gridfs download stream from a parsed ObjectID that contains
     * any given file's ID.
     *
     * @param string $fileId
     * @return resource
     *
     * @see \MongoDB\GridFS\Bucket openDownloadStream
     */
    abstract protected function createDownloadStreamFromFile(string $fileId);

    /**
     * Deletes a given file from the GridFS bucket.
     * IE. All of its **data chunks** and **file metadata**
     * in the _chunks_ and _files_ collections respectively.
     *
     * @param string $fileId
     * @return void
     */
    abstract protected function deleteFileFromBucket(string $fileId): void;

    protected final static function parseObjectId(string $fileId): ObjectId
    {
        return new ObjectId($fileId);
    }
}
