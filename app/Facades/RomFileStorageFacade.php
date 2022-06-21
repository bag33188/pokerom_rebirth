<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\RomFilesHandler;

class RomFileStorageFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RomFilesHandler::class;
    }
}
