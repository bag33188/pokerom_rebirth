<?php

namespace App\Services\GridFS;

use Utils\Modules\GridFS\Client\AbstractGridFSConnection as GridFSConnection;

class RomFilesConnection extends GridFSConnection
{
    protected string $entityName = 'pokerom_files.gridfs';

    /**
     * Create new GridFS Connection Instance
     *
     * @param RomFilesDatabase $romFilesDatabase
     */
    public function __construct(RomFilesDatabase $romFilesDatabase)
    {
        parent::__construct($romFilesDatabase);
    }
}
