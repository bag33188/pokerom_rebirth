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
     * @return int
     */
    protected function updateUserSetAdminRole(int $userId): int
    {
        $query = ['role' => UserRole::ADMIN->value];
        return DB::connection('mysql')
            ->table('users')
            ->where('id', '=', $userId)
            ->update($query);
    }

    /**
     * Resets user's role to default user.
     *
     * _Poses potential security threat. Make sure logic is encapsulated in conditional that checks if
     * current Authenticated user is administrator._
     *
     * @param int $userId
     * @return int
     */
    protected function updateUserSetDefaultRole(int $userId): int
    {
        $query = ['role' => UserRole::DEFAULT->value];
        return DB::connection('mysql')
            ->table('users')
            ->where('id', '=', $userId)
            ->update($query);
    }
}
