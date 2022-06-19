<?php

namespace App\Modules;

use Illuminate\Support\Facades\Facade;

class FileHandlerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FileHandler::class;
    }
}
