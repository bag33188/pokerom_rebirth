<?php

namespace App\Facades;

use App\Repositories\RomRepository;

class RomRepositoryFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RomRepository::class;
    }
}
