<?php

namespace Utils\Classes;

use Jenssegers\Mongodb\Eloquent\Model as MongoDbModel;

/**
 * Laravel IDEA Helper does not support MongoDB objects (at least not very well).
 * The purpose of this abstract class is to provider easier hinting and implementation
 * of this app's {@see \App\Models\RomFile RomFile} model.
 *
 * @see \App\Models\RomFile RomFile
 */
abstract class AbstractGridFSFile extends MongoDbModel
{
    public readonly string $_id;
    public readonly int $chunkSize;
    public readonly string $filename;
    public readonly int $length;
    public readonly string $uploadDate;
    public readonly string $md5;
}
