<?php

namespace Utils\Modules\GridFS;

abstract class GridFS
{
    /** @var string name of gridfs bucket (default is `fs`) */
    public readonly string $bucketName;

    /** @var string name of mongodb database */
    public readonly string $databaseName;

    /** @var int size to store chunked files as */
    public readonly int $chunkSize;
}
