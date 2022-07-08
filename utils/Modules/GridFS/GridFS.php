<?php

namespace Utils\Modules\GridFS;

abstract class GridFS
{
    /** @var string unique name/identifier for each instance of module */
    protected string $entityName;

    /** @var string name of mongodb database */
    protected string $databaseName;

    /**
     * name of gridfs file bucket (default is `fs`)
     *
     * @var string
     */
    protected string $bucketName;

    /**
     * size of chunks to store files as (default is `261120`, `255kb`)
     *
     * @var int
     */
    protected int $chunkSize;
}
