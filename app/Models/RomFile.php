<?php

namespace App\Models;

abstract class RomFile extends File
{
    public string $_id;
    public int $chunkSize;
    public string $filename;
    public int $length;
    public string $uploadDate;
    public string $md5;
}
