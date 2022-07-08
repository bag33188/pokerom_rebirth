<?php

namespace App\Repositories\Queries;

use Illuminate\Support\Facades\DB;

trait GameQueries
{
    protected function findRomsWithNoGame()
    {
        $sql = /** @lang MariaDB */
            "CALL FindRomsWithNoGame";
        return DB::raw($sql);
    }

    protected function parseProperGameTypeString() {
        $sql = /** @lang MariaDB */
            "SELECT FORMAT_GAME_TYPE_STRING(?) AS gameType;";
       return
            DB::raw($sql);
    }
}
