<?php

namespace Utils\Classes;

abstract class AbstractGridFSDatabase
{
    public readonly string $bucketName;
    public readonly string $databaseName;
    public readonly int $chunkSize;

    abstract protected function setDatabaseProperties(): void;

    abstract public static function getMongoURI(): string;
}
