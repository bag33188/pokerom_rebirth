<?php

namespace Utils\Classes;

abstract class AbstractGridFSDatabase
{
    public readonly string $bucketName;
    public readonly string $databaseName;
    public readonly int $chunkSize;

    /**
     * Set `bucketName`, `databaseName`, `chunkSize` properties for database
     *
     * @return void
     */
    abstract protected function setDatabaseProperties(): void;

    /**
     * Construct a MongoDB connection string (mongoURI)
     *
     * @return string
     */
    abstract public static function getMongoURI(): string;
}
