<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Facades;

use App\Services\GridFS\RomFilesGridFSConnection;
use Illuminate\Support\Facades\Facade;

class RomFilesGridFSConnectionFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RomFilesGridFSConnection::class;
    }
}
