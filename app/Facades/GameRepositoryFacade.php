<?php

namespace App\Facades;

use App\Repositories\GameRepository;
use Illuminate\Support\Facades\Facade;

class GameRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GameRepository::class;
    }
}
