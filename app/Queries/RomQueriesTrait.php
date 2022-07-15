<?php

namespace App\Queries;

use Utils\Modules\QueryObject;

trait RomQueriesTrait
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
        return new QueryObject($sql, $params);
    }

    protected function updateRomFromRomFileData(string $romFileId, int $romFileSize, int $romId): QueryObject
    {
        $sql =
            /** @lang MariaDB */
            "CALL UpdateRomFromRomFileData(:romFileId, :romFileSize, :romId);";
        $params = ['romFileId' => $romFileId, 'romFileSize' => $romFileSize, 'romId' => $romId];
        return new QueryObject($sql, $params);
    }

    protected function findMatchingRomFromFilename(string $romFilename): QueryObject
    {
        $sql = /** @lang MariaDB */
            "CALL FindMatchingRomFromFilename(?);";
        $params = [$romFilename];
        return new QueryObject($sql, $params);
    }

    /**
     * ### Property accessor: **`count`**
     *
     * @return QueryObject
     */
    protected function countRomsInDatabase(): QueryObject
    {
        $sql = /** @lang MariaDB */
            "CALL CountPokeROMData(:selection);";
        $params = ['selection' => 'roms'];
        return new QueryObject($sql, $params);
    }
}
