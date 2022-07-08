<?php

namespace App\Queries;

use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use Utils\Classes\_Object\QueryObject;

trait RomQueries
{
    #[ArrayShape(['query' => "\Illuminate\Database\Query\Expression", 'bindings' => "int[]"])]
    protected function formatRomSize(int $romSize): array
    {
        $sql = /** @lang MariaDB */
            "SELECT HIGH_PRIORITY FORMAT_ROM_SIZE(?) AS readable_size;";
        $params = [$romSize];
        return ['query' => DB::raw($sql), 'bindings' => $params];
    }

    #[ArrayShape(['query' => "\Illuminate\Database\Query\Expression", 'bindings' => "array"])]
    protected function linkRomToFile(string $romFileId, int $romFileSize, int $romId): array
    {
        $sql =
            /** @lang MariaDB */
            "CALL LinkRomToFile(:romFileId, :romFileSize, :romId);";
        $params = ['romFileId' => $romFileId, 'romFileSize' => $romFileSize, 'romId' => $romId];
        new QueryObject(DB::raw($sql), $params);
        return ['query' => DB::raw($sql), 'bindings' => $params];
    }
}
