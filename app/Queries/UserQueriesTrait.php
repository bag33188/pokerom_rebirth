<?php

namespace App\Queries;

use App\Enums\UserRoleEnum as UserRole;
use Illuminate\Support\Facades\DB;

trait UserQueriesTrait
{
    /**
     * Will make given user admin.
     *
     * _Poses potential security threat. Make sure logic is encapsulated in conditional that checks if
     * current Authenticated user is administrator._
     *
     * @param int $userId
     * @return void
     */
    protected function updateUserSetAdminRole(int $userId): void
    {
        DB::connection('mysql')
            ->table('users')
            ->where('id', '=', $userId)
            ->update(['role' => UserRole::ADMIN->value]);
    }

    /**
     * Resets user's role to default user.
     *
     * _Poses potential security threat. Make sure logic is encapsulated in conditional that checks if
     * current Authenticated user is administrator._
     *
     * @param int $userId
     * @return void
     */
    protected function updateUserSetDefaultRole(int $userId): void
    {
        DB::connection('mysql')
            ->table('users')
            ->where('id', '=', $userId)
            ->update(['role' => UserRole::DEFAULT->value]);
    }
}
