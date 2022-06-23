<?php

namespace Utils\Classes;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Jenssegers\Mongodb\Eloquent\Model;
use Utils\Modules\GridFS;

abstract class AbstractGfsFilesHandler extends GridFS
{
    protected UploadedFile $file;
    protected string $filename;
    protected string $filepath;

    /**
     * The path on the server to which the uploaded file should be retrieved from.
     * @var string
     */
    protected static string $serverUploadFilePath;

    protected const DOWNLOAD_CHUNK_SIZE = 0x3FC00;

    abstract public function getFilename(): string;

    public abstract function getFileDocument(): Model;

    public abstract function upload(UploadedFile $file): void;

    public abstract function download(string $fileId): void;

    public abstract function destroy(File $file): void;

    /**
     * Sets all needed file information for uploading to database
     *
     * @param UploadedFile $file
     * @return void
     */
    protected abstract function setUploadFileData(UploadedFile $file): void;

    /**
     * Creates the filename string from the given uploaded file.
     * Checks if it is in a valid format and then
     * normalizes the filename.
     *
     * @return void
     *
     * @see normalizeFileName
     * @see checkFormatOfFileName
     */
    protected abstract function createFileNameFromFile(): void;

    /**
     * Concatenates the server's upload file path with the filename
     *
     * @return void
     */
    protected abstract function createUploadFilePathFromFile(): void;

    /**
     * Opens a file stream from the defined filepath and
     * opens a mongodb gridfs upload stream using the file's name and
     * newly opened filestream.
     *
     * @return void
     *
     * @see \MongoDB\GridFS\Bucket uploadFromStream
     */
    protected abstract function uploadFileFromStream(): void;

    /**
     * Opens a gridfs download stream from a parsed ObjectID that contains
     * any given file's ID.
     *
     * @param string $fileId
     * @return resource
     *
     * @see \MongoDB\GridFS\Bucket openDownloadStream
     */
    protected abstract function createDownloadStreamFromFile(string $fileId);

    /**
     * Deletes a given file from the GridFS bucket.
     * IE. All of its **data chunks** and **file metadata**
     * in the _chunks_ and _files_ collections respectively.
     *
     * @param string $fileId
     * @return void
     */
    protected abstract function deleteFileFromBucket(string $fileId): void;
}
