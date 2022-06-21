<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Facades;

use App\Modules\RomFilesHandler;
use Illuminate\Support\Facades\Facade;

class RomFileStorageFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RomFilesHandler::class;
    }
}
