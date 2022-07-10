<?php

namespace App\Facades;

use App\Actions\UserActions;
use Illuminate\Support\Facades\Facade;

class UserActionsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return UserActions::class;
    }
}
