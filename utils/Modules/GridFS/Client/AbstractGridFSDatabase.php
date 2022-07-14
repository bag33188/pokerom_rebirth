<?php

namespace GridFS\Client;

use GridFS\GridFS;
use GridFS\Support\MongoUtils as MongoUtil;

/**
 * GridFS Database Class for defining a MongoDB Database
 */
abstract class AbstractGridFSDatabase extends GridFS
{
    /**
     * specify whether to use authenticate when connecting to mongodb.
     *
     * _note: only allows username/password auth_
     *
     * @var bool
     */
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
        self::$gfsConfig = MongoUtil::getGridFSConfigArray();
        self::$mongoConfig = MongoUtil::getMongoConfigArray();
    }

    public function mongoURI(): string
    {
        $dsnBuilder = _SPACE .
            self::$mongoConfig['driver'] . '://' .
            self::$mongoConfig['username'] . ':' .
            self::$mongoConfig['password'] . '@' .
            self::$mongoConfig['host'] . ':' .
            self::$mongoConfig['port'] . '/';
        if ($this->useAuth === true) {
            $dsnBuilder .= '?' .
                'authMechanism=' .
                (@self::$mongoConfig['options']['authMechanism'] ?? 'DEFAULT') .
                '&authSource=' .
                (@self::$mongoConfig['options']['authSource'] ?? 'admin');
        }
        return ltrim($dsnBuilder);
    }
}
