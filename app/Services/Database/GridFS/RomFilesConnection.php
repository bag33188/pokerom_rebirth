<?php

namespace App\Services\Database\GridFS;

use GridFS\Client\AbstractGridFSConnection as GridFSConnection;

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
