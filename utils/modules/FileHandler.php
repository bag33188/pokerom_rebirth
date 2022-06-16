<?php

namespace Modules;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileHandler extends GridFS
{
    private UploadedFile $file;
    private string $filename;
    private string $filepath;
    private bool $checkValidFilename;

    private const SERVER_FILES_CONFIG_PATH = 'filesystems.server_rom_files_path';
    protected final const VALID_FILENAME = "/^([\w\d\s\-_]{3,32})\.[\w\d]{1,3}$/i";

    public function __construct($databaseName = null, $bucketName = null, $chunkSize = null)
    {
        parent::__construct($databaseName, $bucketName, $chunkSize);
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * **Only required if storing a file**
     *
     * @param UploadedFile $file Your request file being uploaded from the form field
     * @param bool $checkFilenameFormatValidity Check if filename of upload file is valid
     * @return void
     */
    public function setUploadFileData(UploadedFile $file, bool $checkFilenameFormatValidity = false): void
    {
        $this->file = $file;
        $this->checkValidFilename = $checkFilenameFormatValidity;
        $this->createFileNameFromFile();
        $this->createUploadFilePathFromFile();
    }

    private function createFileNameFromFile(): void
    {
        $this->filename = $this->file->getClientOriginalName();
        $this->checkFormatOfFileNameIfRequested();
        self::normalizeFileName($this->filename);
    }

    private function createUploadFilePathFromFile(): void
    {
        $this->filepath = sprintf("%s/%s",
            Config::get(self::SERVER_FILES_CONFIG_PATH), $this->filename);
    }

    public function uploadFileFromStream(): void
    {
        $stream = fopen($this->filepath, 'rb');
        $this->gfsBucket->uploadFromStream($this->filename, $stream);
    }

    /**
     * @param string $fileId
     * @return resource
     */
    public function getDownloadStreamFromFile(string $fileId)
    {
        return $this->gfsBucket->openDownloadStream(parent::parseObjectId($fileId));
    }

    public function getFileDocument(): File
    {
        return File::where('filename', '=', $this->getFilename())->first();
    }

    public function deleteFileFromBucket(string $fileId): void
    {
        $this->gfsBucket->delete(parent::parseObjectId($fileId));
    }

    private function checkFormatOfFileNameIfRequested()
    {
        if ($this->checkValidFilename === true) {
            if (!preg_match(self::VALID_FILENAME, $this->filename)) {
                $badRequestErrorMessage = 'Invalid filename detected.' . ' ' .
                    'Matched against pattern: ' . '\`' . self::VALID_FILENAME . '\`';
                throw new BadRequestHttpException($badRequestErrorMessage);
            }
        }
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
