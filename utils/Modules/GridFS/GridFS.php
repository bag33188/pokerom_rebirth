<?php

namespace GridFS;

abstract class GridFS
{
    /**
     * unique name/identifier for each instance of module
     * @var string
     */
    protected string $entityName;

    /**
     * name of mongodb database
     *
     * @var string
     */
    public string $databaseName;

    /**
     * name of gridfs file bucket (default is `fs`)
     *
     * @var string
     */
    public string $bucketName;

    /**
     * size of chunks to store files as (default is `261120`, `255kb`)
     *
     * @var int
     */
    public int $chunkSize;
}
