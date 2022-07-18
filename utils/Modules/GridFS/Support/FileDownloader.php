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
    private $fileStream;

    /** @var int */
    private int $fileBufferSize;

    /** `261120` Bytes (`255` Kibibytes) @var int */
    private const DEFAULT_BUFFER_SIZE = 0x3FC00; // 261,120

    /**
     * @param resource $fileStream
     * @param int $fileBufferSize
     */
    public function __construct($fileStream, int $fileBufferSize = self::DEFAULT_BUFFER_SIZE)
    {
        $this->fileStream = $fileStream;
        $this->fileBufferSize = $fileBufferSize;
    }

    /**
     * Download file on class invocation.
     *
     * @return void
     * @see downloadFile
     */
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
        return fread($this->fileStream, $this->fileBufferSize);
    }

    private function closeFileStream(): void
    {
        fclose($this->fileStream);
    }

    private function printOutCurrentFileBuffer(): void
    {
        echo $this->getCurrentFileBuffer();
    }

    private function printBytesIfNotEndOfFile(): void
    {
        while (!$this->isEndOfFile()) {
            $this->printOutCurrentFileBuffer();
        }
    }

    public function downloadFile(): void
    {
        $this->printBytesIfNotEndOfFile();
        $this->closeFileStream();
    }
}
