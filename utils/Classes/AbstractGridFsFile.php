<?php

namespace Utils\Classes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\ObjectId;

abstract class AbstractGridFsFile extends Model
{
    public readonly string $_id;
    public readonly int $chunkSize;
    public readonly string $filename;
    public readonly int $length;
    public readonly string $uploadDate;
    public readonly string $md5;

    abstract public function getObjectId(): ObjectId;

    abstract public function rom(): BelongsTo;
}
