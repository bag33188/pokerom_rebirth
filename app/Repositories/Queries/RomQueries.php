<?php

namespace App\Repositories\Queries;

use Illuminate\Support\Facades\DB;

trait RomQueries
{
    protected function generateReadableRomSize() {
        $sql = /** @lang MariaDB */
            "SELECT HIGH_PRIORITY FORMAT_ROM_SIZE(?) AS readable_size;";
        return DB::raw($sql);
    }
}
