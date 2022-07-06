<?php

namespace Utils\Modules\GridFS;

abstract class GridFS
{
    /** @var string name of mongodb database */
    protected string $databaseName;

    /** @var string name of gridfs file bucket (default is `fs`) */
    protected string $bucketName;

    /** @var int size of chunks to store files as (default is `261120`, `255kb`) */
    protected int $chunkSize;
}
