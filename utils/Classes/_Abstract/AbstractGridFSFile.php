<?php

namespace Utils\Classes\_Abstract;

use Jenssegers\Mongodb\Eloquent\Model as MongoDbModel;

/**
 * Laravel IDEA Helper does not support MongoDB objects (at least not very well).
 * The purpose of this abstract class is to provider easier hinting and implementation
 * for GridFS-related models.
 */
abstract class AbstractGridFSFile extends MongoDbModel
{
    /**
     * BSON Type: ObjectID (`objectId`)
     *
     * @var string
     */
    public readonly string $_id;

    /**
     * BSON Type: int32 (`int`)
     *
     * @var int
     */
    public readonly int $chunkSize;

    /**
     * BSON Data Type: String (`string`)
     *
     * @var string
     */
    public readonly string $filename;

    /**
     * BSON Types: int64 (`long`), int32 (`int`)
     *
     * @var int
     */
    public readonly int $length;

    /**
     * BSON Type: Date (`date`)
     *
     * @var string
     */
    public readonly string $uploadDate;

    /**
     * BSON Data Type: String (`string`)
     *
     * @var string
     */
    public readonly string $md5;
}
