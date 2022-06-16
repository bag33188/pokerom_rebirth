<?php

namespace App\Repositories;

use App\Models\Rom;
use Illuminate\Support\Facades\DB;

class RomRepository {
    public function linkRomToFile(Rom $rom) {
        $file = $rom->checkMatchingFile()->first();
        if (isset($file)) {
            DB::statement(/** @lang MariaDB */ "CALL LinkRomToFile(:fileId, :fileSize, :romId);", [
                'fileId' => $file['_id'],
                'fileSize' => $file->length,
                'romId' => $rom->id
            ]);
            $rom->refresh();
            return response()->json([
                'message' => "file found and linked! file id: {$file['_id']}",
                'data' => $rom->refresh()
            ]);

        }
    }
}
