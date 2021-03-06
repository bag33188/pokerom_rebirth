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
            "SELECT HIGH_PRIORITY FORMAT_ROM_SIZE(?) AS `romSize`;";
        $params = [$romSize];
        return new QueryObject($sql, $params);
    }

    /**
     * @param string $romFileId p1
     * @param int $romFileSize p2
     * @param int $romId p3
     * @return QueryObject
     */
    protected function updateRomFromRomFileData(string $romFileId, int $romFileSize, int $romId): QueryObject
    {
        $sql =
            /** @lang MariaDB */
            "CALL spUpdateRomFromRomFileData(:rom_file_id, :rom_file_size, :rom_id);";
        $params = ['rom_file_id' => $romFileId, 'rom_file_size' => $romFileSize, 'rom_id' => $romId];
        return new QueryObject($sql, $params);
    }

    protected function findMatchingRomFromFilename(string $romFilename): QueryObject
    {
        $sql = /** @lang MariaDB */
            "CALL spSelectMatchingRomFromRomFilename(:rom_filename);";
        $params = ['rom_filename' => $romFilename];
        return new QueryObject($sql, $params);
    }
}
