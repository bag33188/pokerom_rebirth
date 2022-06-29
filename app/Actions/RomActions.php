<?php

namespace App\Actions;

use App\Interfaces\RomActionsInterface;
use App\Models\Rom;
use App\Models\RomFile;
use Illuminate\Support\Facades\DB;

class RomActions implements RomActionsInterface
{
    public function setRomDataFromFile(Rom $rom, RomFile $file): void
    {
        $sql =
            DB::raw(/** @lang MariaDB */ "CALL LinkRomToFile(:fileId, :fileSize, :romId);");
        DB::statement($sql, [
            'fileId' => $file->getKey(),
            'fileSize' => $file->length,
            'romId' => $rom->getKey()
        ]);
        $rom->refresh();
    }


    public function linkRomToFileIfExists(Rom $rom): void
    {
        $file = RomRepo::searchForFileMatchingRom($rom->id);
        if (isset($file)) $this->setRomDataFromFile($rom, $file);
    }
}
