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
    private const DOWNLOAD_CHUNK_SIZE = 0xFF000;
    public final const VALID_FILENAME = "/^([\w\d\s\-_]+)\.[\w\d]+$/i";

    public function __construct(string $databaseName = null)
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

    public function upload(UploadedFile $file): void
    {
        $this->setUploadFileData($file);
        $this->uploadFileFromStream();
    }

    public function download(string $fileId): void
    {
        $stream = $this->createDownloadStreamFromFile($fileId);
        $fileDownloader = new FileDownloader($stream, self::DOWNLOAD_CHUNK_SIZE);
        $fileDownloader->downloadFile();
    }

    public function destroy(string $fileId): void
    {
        $this->gfsBucket->delete(self::parseObjectId($fileId));
    }

    private function setUploadFileData(UploadedFile $file): void
    {
        $this->file = $file;
        $this->createFileNameFromFile();
        $this->createUploadFilePathFromFile();
    }

    private function createFileNameFromFile(): void
    {
        $this->filename = @$this->file->getClientOriginalName();
        $this->checkFormatOfFileName();
        self::normalizeFileName($this->filename);
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
    private function createDownloadStreamFromFile(string $fileId)
    {
        return $this->gfsBucket->openDownloadStream(self::parseObjectId($fileId));
    }

    private function checkFormatOfFileName()
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
