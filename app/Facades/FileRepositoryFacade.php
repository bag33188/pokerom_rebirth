<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Facades;

use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Facade;

class FileRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FileRepository::class;
    }
}
