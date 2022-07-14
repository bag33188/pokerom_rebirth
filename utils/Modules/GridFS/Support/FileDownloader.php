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

    protected function isEndOfFile(): bool
    {
        return feof($this->fileStream);
    }

    protected function getCurrentFileBuffer(): false|string
    {
        return fread($this->fileStream, $this->readyBytesChunkSize);
    }

    protected function closeFileStream(): void
    {
        fclose($this->fileStream);
    }

    protected function printBytesIfNotEndOfFile(): void
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
