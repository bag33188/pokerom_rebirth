<?php

/*
 * Custom module for downloading large files.
 *
 * Uses proper streaming to download excessively long files with mass binary content.
 */

namespace GridFS\Support;

class FileDownloader
{
    /** @var resource */
    protected $fileStream;

    /** @var int */
    protected int $readyBytesChunkSize;

    public function __construct(/** @var resource */ $fileStream, int $readyBytesChunkSize = 0x3FC00)
    {
        $this->fileStream = $fileStream;
        $this->readyBytesChunkSize = $readyBytesChunkSize;
    }

    public function __invoke(): void
    {
        $this->downloadFile();
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

    private function printBytesIfNotEndOfFile(): void
    {
        while (!$this->isEndOfFile()) {
            echo $this->getCurrentFileBuffer();
        }
    }

    public function downloadFile(): void
    {
        $this->printBytesIfNotEndOfFile();
        $this->closeFileStream();
    }
}
