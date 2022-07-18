<?php

namespace App\Queries;

use App\Enums\UserRoleEnum as UserRole;
use Illuminate\Support\Facades\DB;

trait UserQueriesTrait
{
    protected function updateUserSetAdmin(int $userId): void
    {
        DB::connection('mysql')
            ->table('users')
            ->where('id', '=', $userId)
            ->update(['role' => UserRole::ADMIN->value]);
    }
}
