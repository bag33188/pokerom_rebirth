<?php

namespace Utils\Classes;

abstract class AbstractGridFsFile
{
    public readonly string $_id;
    public readonly int $chunkSize;
    public readonly string $filename;
    public readonly int $length;
    public readonly string $uploadDate;
    public readonly string $md5;
}
