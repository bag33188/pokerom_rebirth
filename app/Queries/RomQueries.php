<?php

namespace App\Queries;

use Illuminate\Support\Facades\DB;
use Utils\Modules\QueryObject;

trait RomQueries
{
    /**
     * ### Property accessor: **`romSize`**
     *
     * @param int $romSize
     * @return QueryObject
     */
    protected function formatRomSize(int $romSize): QueryObject
    {
        $sql = /** @lang MariaDB */
            "SELECT HIGH_PRIORITY FORMAT_ROM_SIZE(?) AS romSize;";
        $params = [$romSize];
        return new QueryObject(DB::raw($sql), $params);
    }

    protected function linkRomToFile(string $romFileId, int $romFileSize, int $romId): QueryObject
    {
        $sql =
            /** @lang MariaDB */
            "CALL LinkRomToFile(:romFileId, :romFileSize, :romId);";
        $params = ['romFileId' => $romFileId, 'romFileSize' => $romFileSize, 'romId' => $romId];

        return new QueryObject(DB::raw($sql), $params);
    }
}
