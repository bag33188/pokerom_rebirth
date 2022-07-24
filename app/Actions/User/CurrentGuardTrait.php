<?php

namespace App\Actions\User;

use Auth;

trait CurrentGuardTrait
{
    public function showCurrentAuthGuard(): void
    {
        print Auth::getDefaultDriver();
    }
}
