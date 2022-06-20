<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Facades;

use App\Repositories\RomRepository;
use Illuminate\Support\Facades\Facade;

class RomRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RomRepository::class;
    }
}
