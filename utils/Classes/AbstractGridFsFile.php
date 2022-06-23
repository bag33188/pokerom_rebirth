<?php

namespace Utils\Classes;

use Jenssegers\Mongodb\Eloquent\Model as MongoDbModel;

/**
 * Laravel IDEA Helper does not support MongoDB objects (at least not very well).
 * The purpose of this abstract class is to provider easier hinting and implementation
 * of this app's {@link \App\Models\File File} model.
 *
 * @see \App\Models\File File
 */
abstract class AbstractGridFsFile extends MongoDbModel
{
    public readonly string $_id;
    public readonly int $chunkSize;
    public readonly string $filename;
    public readonly int $length;
    public readonly string $uploadDate;
    public readonly string $md5;

    protected final const COLUMNS = array('_id', 'chunkSize', 'filename', 'length', 'uploadDate', 'md5');
}
