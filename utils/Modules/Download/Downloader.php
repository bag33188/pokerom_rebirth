<?php

namespace Utils\Modules\Download;

abstract class Downloader
{
    /** @var resource */
    protected $fileStream;
    /** @var int */
    protected int $readyBytesChunkSize;

    abstract protected function closeFileStream(): void;

    abstract public function downloadFile(): void;

    abstract protected function isEndOfFile(): bool;

    abstract protected function getCurrentFileBuffer(): false|string;

    abstract protected function printBytesIfNotEndOfFile(): void;
}
