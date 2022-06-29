<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Facades;

use App\Services\GridFS\GridFSConnection;
use Illuminate\Support\Facades\Facade;

class GridFSConnectionFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GridFSConnection::class;
    }
}
