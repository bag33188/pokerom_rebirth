<?php

namespace App\Modules;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileHandler extends GridFS
{
    private UploadedFile $file;
    private string $filename;
    private string $filepath;

    private const SERVER_FILES_CONFIG_PATH = 'filesystems.server_rom_files_path';
    protected final const VALID_FILENAME = "/^([\w\d\s\-_]{3,32})\.[\w\d]{1,3}$/i";

    public function __construct($databaseName = null)
    {
        parent::__construct($databaseName);
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getFileDocument(): File
    {
        // todo: move this logic to file repository??
        return File::where('filename', '=', $this->getFilename())->first();
    }

    public function destroy(string $fileId): void
    {
        $this->gfsBucket->delete(parent::parseObjectId($fileId));
    }


    public function upload(UploadedFile $file)
    {
        $this->setUploadFileData($file);
        $this->uploadFileFromStream();
    }

    public function download(string $fileId)
    {
        $stream = $this->getDownloadStreamFromFile($fileId);
        $fileDownloader = new FileDownloader($stream, 0xFF000);
        $fileDownloader->downloadFile();
    }

    private function createFileNameFromFile(): void
    {
        $this->filename = $this->file->getClientOriginalName();
        $this->checkFormatOfFileNameIfRequested();
        self::normalizeFileName($this->filename);
    }

    private function setUploadFileData(UploadedFile $file): void
    {
        $this->file = $file;
        $this->createFileNameFromFile();
        $this->createUploadFilePathFromFile();
    }

    private function createUploadFilePathFromFile(): void
    {
        $this->filepath = sprintf("%s/%s",
            Config::get(self::SERVER_FILES_CONFIG_PATH), $this->filename);
    }

    private function uploadFileFromStream(): void
    {
        $stream = fopen($this->filepath, 'rb');
        $this->gfsBucket->uploadFromStream($this->filename, $stream);
    }

    /**
     * @param string $fileId
     * @return resource
     */
    private function getDownloadStreamFromFile(string $fileId)
    {
        return $this->gfsBucket->openDownloadStream(parent::parseObjectId($fileId));
    }

    private function checkFormatOfFileNameIfRequested()
    {
        if (!preg_match(self::VALID_FILENAME, $this->filename)) {
            $badRequestErrorMessage = 'Invalid filename detected.' . ' ' .
                'Matched against pattern: ' . '`' . self::VALID_FILENAME . '`';
            throw new BadRequestHttpException($badRequestErrorMessage);
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
