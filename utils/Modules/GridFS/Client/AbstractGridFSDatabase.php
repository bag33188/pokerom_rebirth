<?php

namespace Utils\Modules\GridFS\Client;

use Utils\Classes\_Static\MongoMethods;
use Utils\Modules\GridFS\GridFS;

/**
 * GridFS Database Class for defining a MongoDB Database
 */
abstract class AbstractGridFSDatabase extends GridFS
{
    public string $databaseName;
    public string $bucketName;
    public int $chunkSize;
    protected bool $useAuth = false;

    /** @var string[] */
    private static array $gfsConfig;
    /** @var string[] */
    private static array $mongoConfig;

    public function __construct(string $databaseName = null, string $bucketName = null, int $chunkSize = null)
    {
        $this->setConfigVars();

        if (empty($this->databaseName)) {
            $this->databaseName = $databaseName ?? self::$gfsConfig['connection']['database'];
        }
        if (empty($this->bucketName)) {
            $this->bucketName = $bucketName ?? self::$gfsConfig['bucketName'];
        }
        if (empty($this->chunkSize)) {
            $this->chunkSize = $chunkSize ?? self::$gfsConfig['chunkSize'];
        }
    }

    private function setConfigVars(): void
    {
        self::$gfsConfig = MongoMethods::getGridFSConfig();
        self::$mongoConfig = MongoMethods::getMongoConfig();
    }

    public function mongoURI(): string
    {
        if ($this->useAuth === true) {
            return '' .
                self::$mongoConfig['driver'] . '://' .
                self::$mongoConfig['username'] . ':' .
                self::$mongoConfig['password'] . '@' .
                self::$mongoConfig['host'] . ':' .
                self::$mongoConfig['port'] . '/?authMechanism=' .
                self::$mongoConfig['options']['authMechanism'] . '&authSource=' .
                self::$mongoConfig['options']['authSource'];
        } else {
            return '' .
                self::$mongoConfig['driver'] . '://' .
                self::$mongoConfig['username'] . ':' .
                self::$mongoConfig['password'] . '@' .
                self::$mongoConfig['host'] . ':' .
                self::$mongoConfig['port'] . '/';
        }
    }
}
