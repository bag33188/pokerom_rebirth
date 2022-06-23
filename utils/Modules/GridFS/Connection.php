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

    public function __construct()
    {
        self::$mongoConfig = Config::get(self::MONGO_CONF_PREFIX);
        self::$gfsConfig = Config::get(self::GFS_CONF_PREFIX);
    }

    /**
     * Order: <b>Bucket Name (`string`), Chunk Size (`int`), Database Name (`string`)</b>
     *
     * @param string|null $bucketName
     * @param int|null $chunkSize
     * @param string|null $databaseName
     * @return void
     */
    public final function setDatabaseValues(string $bucketName = null, int $chunkSize = null, string $databaseName = null): void
    {
        $this->bucketName = $bucketName ?? self::$gfsConfig['bucketName'];
        $this->chunkSize = $chunkSize ?? self::$gfsConfig['chunkSize'];
        $this->databaseName = $databaseName ?? self::$mongoConfig['database'];
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
