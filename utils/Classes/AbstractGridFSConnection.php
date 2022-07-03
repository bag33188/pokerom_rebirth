<?php

namespace Utils\Classes;

use MongoDB\BSON\ObjectId;
use MongoDB\Client as MongoClient;
use MongoDB\Database;
use MongoDB\GridFS\Bucket;
use Utils\Modules\FileDownloader;
use Utils\Modules\FileMethods;

/**
 * GridFS Connection Class for connection to a GridFS MongoDB Database
 *
 * _Constructor can accept a {@see AbstractGridFSDatabase GridFSDatabase} Object_
 */
abstract class AbstractGridFSConnection implements GridFSBucketMethodsInterface
{
    /** @var string name of gridfs bucket (default is `fs`) */
    protected string $bucketName;
    /** @var string name of mongodb database */
    protected string $databaseName;
    /** @var int size to store chunked files as */
    protected int $chunkSize;
    /** @var string mongodb connection string */
    protected string $dsn;
    /** @var Bucket gridfs bucket object */
    protected Bucket $bucket;

    public function __construct()
    {
        $this->setConnectionValues();
        $this->setBucket();
    }

    /**
     * Set all connection values
     *  + {@link bucketName bucketName}
     *  + {@link chunkSize chunkSize}
     *  + {@link databaseName databaseName}
     *  + {@link dsn dsn}, see {@see AbstractGridFSDatabase::getMongoURI MongoURI}
     *
     * @return void
     */
    abstract protected function setConnectionValues(): void;

    protected final function connectToMongoClient(): Database
    {
        $db = new MongoClient($this->dsn);
        return $db->selectDatabase($this->databaseName);
    }

    protected final function setBucket(): void
    {
        $mongodb = $this->connectToMongoClient();
        $this->bucket = $mongodb->selectGridFSBucket([
            'chunkSizeBytes' => $this->chunkSize,
            'bucketName' => $this->bucketName
        ]);
    }

    public final function getBucket(): Bucket
    {
        return $this->bucket;
    }

    public function upload(string $filename): void
    {
        $stream = fopen(FileMethods::makeFilepathFromFilename($filename), 'rb');
        $this->bucket->uploadFromStream($filename, $stream);
        fclose($stream);
    }

    public function download(ObjectId $fileId, int $downloadTransferSize = null): void
    {
        $stream = $this->bucket->openDownloadStream($fileId);
        (new FileDownloader($stream, $downloadTransferSize))();
    }

    public function delete(ObjectId $fileId): void
    {
        $this->bucket->delete($fileId);
    }
}
