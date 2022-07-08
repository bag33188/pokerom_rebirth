<?php

namespace Utils\Modules\GridFS\Client;

use Utils\Classes\_Static\MongoMethods;
use Utils\Modules\GridFS\GridFS;

/**
 * GridFS Database Class for defining a MongoDB Database
 */
abstract class AbstractGridFSDatabase extends GridFS
{
    // chance accessors on inherited properties
    // protected => public

    public string $databaseName;
    public string $bucketName;
    public int $chunkSize;

    /** @var bool specify whether to use authenticate when connecting to mongodb. _only allows username/password auth_ */
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
        $this->gfsConfig = MongoMethods::getGridFSConfig();
        $this->mongoConfig = MongoMethods::getMongoConfig();
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
                @$this->mongoConfig['options']['authSource'] ?? 'admin';
        }
        return $dsnBuilder;
    }
}
