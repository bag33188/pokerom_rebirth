<?php

namespace App\Actions\User;

use Auth;

trait CurrentGuardTrait
{
    public function showCurrentAuthGuard(): void
    {
        echo Auth::getDefaultDriver();
    }
}
