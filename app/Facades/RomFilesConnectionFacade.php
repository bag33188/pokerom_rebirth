<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Facades;

use App\Services\GridFS\RomFilesConnection;
use Illuminate\Support\Facades\Facade;

class RomFilesConnectionFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RomFilesConnection::class;
    }
}