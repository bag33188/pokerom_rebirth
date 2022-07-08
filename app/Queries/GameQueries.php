<?php

namespace App\Queries;

use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

trait GameQueries
{
    #[ArrayShape(['query' => "\Illuminate\Database\Query\Expression", 'bindings' => "null"])]
    protected function findRomsWithNoGame(): array
    {
        $sql = /** @lang MariaDB */
            "CALL FindRomsWithNoGame";
        $params = null;
        return ['query' => DB::raw($sql), 'bindings' => $params];
    }

    #[ArrayShape(['query' => "\Illuminate\Database\Query\Expression", 'bindings' => "string[]"])]
    protected function formatGameTypeString(string $gameType): array
    {
        $sql = /** @lang MariaDB */
            "SELECT FORMAT_GAME_TYPE_STRING(?) AS gameType;";
        $params = [$gameType];
        return ['query' => DB::raw($sql), 'bindings' => $params];
    }
}
