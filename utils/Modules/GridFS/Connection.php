<?php

namespace Utils\Modules\GridFS;

use Illuminate\Support\Facades\Config;
use MongoDB\Client as MongoClient;
use MongoDB\Database;
use MongoDB\GridFS\Bucket;

class Connection
{
    protected string $bucketName;
    protected string $databaseName;
    protected int $chunkSize;
    protected Bucket $gfsBucket;
    private static array $mongoConfig;
    private static array $gfsConfig;

    private const GFS_CONF_PREFIX = 'gridfs';
    private const MONGO_CONF_PREFIX = 'gridfs.connection';

    public function __construct(string $databaseName = null, string $bucketName = null, int $chunkSize = null)
    {
        self::$mongoConfig = Config::get(self::MONGO_CONF_PREFIX);
        self::$gfsConfig = Config::get(self::GFS_CONF_PREFIX);
        $this->setDatabaseValues($databaseName, $bucketName, $chunkSize);
    }

    /**
     * Order: **_Database Name_ (`string`), _Bucket Name_ (`string`), _Chunk Size_ (`int`)**
     *
     * @param string $databaseName Name of desired MongoDB database
     * @param string $bucketName Name of the bucket for grid file storage
     * @param int $chunkSize Size of chunked files to be stored in the grid
     * @return void
     */
    public final function setDatabaseValues(string $databaseName,
                                            string $bucketName,
                                            int    $chunkSize): void
    {
        $this->databaseName = $databaseName ?? self::$mongoConfig['database'];
        $this->bucketName = $bucketName ?? self::$gfsConfig['bucketName'];
        $this->chunkSize = $chunkSize ?? self::$gfsConfig['chunkSize'];
        $this->setGfsBucket();
    }

    private static function GFS_MONGO_URI(): string
    {
        return '' .
            self::$gfsConfig['driver'] . '://' .
            self::$mongoConfig['username'] . ':' .
            self::$mongoConfig['password'] . '@' .
            self::$mongoConfig['host'] . ':' .
            self::$mongoConfig['port'] . '/?authMechanism=' .
            self::$mongoConfig['auth']['mechanism'] . '&authSource=' .
            self::$mongoConfig['auth']['source'];
    }

    private function connectToMongoClient(): Database
    {
        $dsn = self::GFS_MONGO_URI();
        $db = new MongoClient($dsn);
        return $db->selectDatabase($this->databaseName);
    }

    private function setGfsBucket(): void
    {
        $mongodb = $this->connectToMongoClient();
        $this->gfsBucket = $mongodb->selectGridFSBucket([
            'chunkSizeBytes' => $this->chunkSize,
            'bucketName' => $this->bucketName
        ]);
    }
}
