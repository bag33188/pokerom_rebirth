<?php

namespace App\Facades;

use App\Repositories\GameRepository;

class GameRepositoryFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return GameRepository::class;
    }
}
