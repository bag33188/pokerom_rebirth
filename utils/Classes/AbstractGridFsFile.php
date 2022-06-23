<?php

namespace Utils\Classes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model as MongoDbModel;
use MongoDB\BSON\ObjectId;

/**
 * Laravel IDEA Helper does not support MongoDB objects (at least not very well).
 * The purpose of this abstract class is to provider easier hinting and implementation
 * of this app's {@link \App\Models\File File model}.
 *
 * @see \App\Models\File File Model
 */
abstract class AbstractGridFsFile extends MongoDbModel
{
    public readonly string $_id;
    public readonly int $chunkSize;
    public readonly string $filename;
    public readonly int $length;
    public readonly string $uploadDate;
    public readonly string $md5;

    abstract public function getObjectId(): ObjectId;
}
