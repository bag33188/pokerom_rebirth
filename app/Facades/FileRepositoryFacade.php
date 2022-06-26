<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Facades;

use App\Repositories\RomFileRepository;
use Illuminate\Support\Facades\Facade;

class FileRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RomFileRepository::class;
    }
}
