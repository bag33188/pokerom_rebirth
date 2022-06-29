<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Facades;

use App\Services\GridFS\RomFilesBucket;
use Illuminate\Support\Facades\Facade;
use Utils\Modules\GridFS\Connection;

class RomFileBucketFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Connection::class;
    }
}
