<?php

namespace App\Queries;

use Illuminate\Support\Facades\DB;
use Utils\Modules\QueryObject;

trait GameQueries
{
    protected function findRomsWithNoGame(): QueryObject
    {
        $sql = /** @lang MariaDB */
            "CALL FindRomsWithNoGame";
        return new QueryObject(DB::raw($sql));
    }

    protected function formatGameTypeString(string $gameType): QueryObject
    {
        $sql = /** @lang MariaDB */
            "SELECT FORMAT_GAME_TYPE_STRING(?) AS gameType;";
        $params = [$gameType];
        return new QueryObject(DB::raw($sql), $params);
    }
}
