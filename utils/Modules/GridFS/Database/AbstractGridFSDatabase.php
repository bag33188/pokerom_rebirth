<?php

namespace Utils\Modules\GridFS\Database;

use Utils\Modules\GridFS\GridFS;

/**
 * GridFS Database Class for defining a MongoDB Database
 */
abstract class AbstractGridFSDatabase extends GridFS
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
     * ### Intended Usage
     *
     * ```php
     * $this->bucketName = Config::get("gridfs.bucketName");
     * $this->chunkSize = Config::get("gridfs.chunkSize");
     * $this->databaseName = Config::get("gridfs.connection.database");
     * ```
     *
     * @return void
     */
    abstract protected function setDatabaseProperties(): void;

    /**
     * Construct a MongoDB connection string (mongoURI).
     *
     * ### Example Mongo URI:
     *
     * **`mongodb://<username>:<password>@<host>:<port>/?authMechanism=SCRAM-SHA-256&authSource=admin`**
     *
     * ### Intended Usage:
     *
     * ```php
     * return "mongodb://localhost:12707/?authSource=admin";
     * ```
     *
     * @link https://www.mongodb.com/docs/manual/reference/connection-string/ MongoDB Connection String
     *
     * @return string
     */
    abstract public static function mongoURI(): string;
}
