<?php

namespace App\Queries;

use Utils\Modules\QueryObject;

trait GameQueriesTrait
{
    protected function findRomsWithNoGame(): QueryObject
    {
        $sql = /** @lang MariaDB */
            "CALL `spSelectRomsWithNoGame`;";
        return new QueryObject($sql);
    }

    /**
     * ### Property accessor: **`gameType`**
     *
     * @param string $gameType
     * @return QueryObject
     */
    protected function formatGameType(string $gameType): QueryObject
    {
        $sql = /** @lang MariaDB */
            "SELECT HIGH_PRIORITY FORMAT_GAME_TYPE(?) AS `gameType`;";
        $params = [$gameType];
        return new QueryObject($sql, $params);
    }

    /**
     * ### Order By:
     *
     * ```
     * rom_id => 1,
     * generation => 1
     * ```
     *
     * @return string[][]
     */
    protected function sortByRomIdAscGenerationAsc(): array
    {
        return array(
            ['rom_id', 'asc'],
            ['generation', 'asc']
        );
    }
}
