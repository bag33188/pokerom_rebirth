<?php

namespace Modules;

use Illuminate\Support\Facades\Config;
use Illuminate\Http\UploadedFile;

class FileHandler extends GridFS
{
    private UploadedFile $file;
    private string $filename;
    private string $filepath;

    private const SERVER_FILES_CONFIG_PATH = 'filesystems.server_rom_files_path';

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
     * @return void
     */
    public function setUploadFileData(UploadedFile $file): void
    {
        $this->file = $file;
        $this->createFileNameFromFile();
        $this->createUploadFilePathFromFile();
    }

    private function createFileNameFromFile(): void
    {
        $this->filename = self::normalizeFileName(
            $this->file->getClientOriginalName());
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

    public function deleteFileFromBucket(string $fileId): void
    {
        $this->gfsBucket->delete(parent::parseObjectId($fileId));
    }

    private static function normalizeFileName(string $filename): string
    {
        [$name, $ext] = explode('.', $filename);
        return sprintf('%s.%s', trim($name), strtolower($ext));
    }
}
