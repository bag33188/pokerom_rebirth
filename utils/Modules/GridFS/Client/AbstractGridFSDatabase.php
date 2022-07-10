<?php

namespace Utils\Modules\GridFS\Client;

use Utils\Classes\_Static\MongoUtils as MongoUtil;
use Utils\Modules\GridFS\GridFS;

/**
 * GridFS Database Class for defining a MongoDB Database
 */
abstract class AbstractGridFSDatabase extends GridFS
{
    // change accessors on inherited properties
    // protected => public

    /** @var string name of mongodb database */
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

    /**
     * specify whether to use authenticate when connecting to mongodb.
     *
     * _note: only allows username/password auth_
     *
     * @var bool
     */
    protected bool $useAuth = false;

    /** @var string[] */
    private array $gfsConfig;
    /** @var string[] */
    private array $mongoConfig;

    public function __construct(string $databaseName = null, string $bucketName = null, int $chunkSize = null)
    {
        $this->setConfigVars();

        if (empty($this->databaseName)) {
            $this->databaseName = $databaseName ?? $this->gfsConfig['connection']['database'];
        }
        if (empty($this->bucketName)) {
            $this->bucketName = $bucketName ?? $this->gfsConfig['bucketName'];
        }
        if (empty($this->chunkSize)) {
            $this->chunkSize = $chunkSize ?? $this->gfsConfig['chunkSize'];
        }
    }

    private function setConfigVars(): void
    {
        $this->gfsConfig = MongoUtil::getGridFSConfigArray();
        $this->mongoConfig = MongoUtil::getMongoConfigArray();
    }

    public function mongoURI(): string
    {
        $dsnBuilder = '' .
            $this->mongoConfig['driver'] . '://' .
            $this->mongoConfig['username'] . ':' .
            $this->mongoConfig['password'] . '@' .
            $this->mongoConfig['host'] . ':' .
            $this->mongoConfig['port'] . '/';
        if ($this->useAuth === true) {
            $dsnBuilder .= '?' .
                'authMechanism=' .
                (@$this->mongoConfig['options']['authMechanism'] ?? 'DEFAULT') .
                '&authSource=' .
                (@$this->mongoConfig['options']['authSource'] ?? 'admin');
        }
        return $dsnBuilder;
    }
}
