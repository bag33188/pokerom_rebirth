<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Facades;

use App\Services\GridFS\RomFilesBucket;
use Illuminate\Support\Facades\Facade;

class RomFileBucketFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RomFilesBucket::class;
    }
}
