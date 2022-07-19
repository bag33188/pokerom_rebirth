<?php

namespace App\Queries;

use App\Enums\UserRoleEnum as UserRole;
use Illuminate\Support\Facades\DB;

trait UserQueriesTrait
{
    /**
     * **Raw Trait Logic Warning:**
     *
     * GOOD IDEA TO WRAP THIS INSIDE A CONDITIONAL THAT CHECKS IF USER IS ADMINISTRATOR
     * BEFORE EXECUTING QUERY
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
}
