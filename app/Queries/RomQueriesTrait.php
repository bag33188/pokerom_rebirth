<?php

namespace App\Queries;

use Illuminate\Support\Facades\DB;
use Utils\Modules\QueryObject;

trait RomQueriesTrait
{
    /**
     * ### Property accessor: **`romSize`**
     *
     * @param int $romSize
     * @return QueryObject
     */
    public function formatRomSize(int $romSize): QueryObject
    {
        $sql = /** @lang MariaDB */
            "SELECT HIGH_PRIORITY FORMAT_ROM_SIZE(?) AS romSize;";
        $params = [$romSize];
        return new QueryObject(DB::raw($sql), $params);
    }

    public function linkRomToFile(string $romFileId, int $romFileSize, int $romId): QueryObject
    {
        $sql =
            /** @lang MariaDB */
            "CALL LinkRomToFile(:romFileId, :romFileSize, :romId);";
        $params = ['romFileId' => $romFileId, 'romFileSize' => $romFileSize, 'romId' => $romId];

        return new QueryObject(DB::raw($sql), $params);
    }

    public function findMatchingRomFromFilename(string $romFilename): QueryObject
    {
        $sql = "CALL FindMatchingRomFromFilename(?);";
        $params = [$romFilename];
        return new QueryObject(DB::raw($sql), $params);
    }
}
