<?php

namespace App\Actions\User;

use Auth;

trait ShowCurrentGuardTrait
{
    public function currentGuard(): void
    {
        print Auth::getDefaultDriver();
    }
}
