<?php

namespace Utils\Classes;

abstract class AbstractGridFSDatabase
{
    public readonly string $bucketName;
    public readonly string $databaseName;
    public readonly int $chunkSize;

    public function __construct()
    {
        $this->setDatabaseProperties();
    }

    /**
     * Set `bucketName`, `databaseName`, `chunkSize` properties for database
     *
     * @return void
     */
    abstract protected function setDatabaseProperties(): void;

    /**
     * Construct a MongoDB connection string (mongoURI).
     *
     * Example Mongo URI:
     *
     * **`mongodb://<username>:<password>@<host>:<port>/?authMechanism=SCRAM-SHA-256&authSource=admin`**
     *
     * @return string
     */
    abstract public static function getMongoURI(): string;
}
