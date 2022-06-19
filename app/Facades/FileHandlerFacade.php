<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FileHandlerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filehandler';
    }
}
