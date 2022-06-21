<?php

namespace Modules;

/**
 * Only use this module if you need to download large files (IE. in excess of 2 Gigabytes)
 */
class FileDownloader
{
    /** @var resource */
    private $fileStream;
    private int $readyBytesChunkSize;

    public function __construct(/** @var resource */ $fileStream, int $readyBytesChunkSize = 0x3FC00)
    {
        $this->fileStream = $fileStream;
        $this->readyBytesChunkSize = $readyBytesChunkSize;
    }

    private function isEndOfFile(): bool
    {
        return feof($this->fileStream);
    }

    private function getCurrentFileBuffer(): false|string
    {
        return fread($this->fileStream, $this->readyBytesChunkSize);
    }

    private function closeFileStream(): void
    {
        fclose($this->fileStream);
    }

    public function downloadFile(): void
    {
        $this->printBytesIfNotEndOfFile();
        $this->closeFileStream();
    }

    public function printBytesIfNotEndOfFile(): void
    {
        while (!$this->isEndOfFile()) {
            echo $this->getCurrentFileBuffer();
        }
    }
}
