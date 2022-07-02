<?php

namespace App\Actions;

use App\Interfaces\RomActionsInterface;
use App\Models\Rom;
use App\Models\RomFile;
use Illuminate\Support\Facades\DB;
use RomRepo;

class RomActions implements RomActionsInterface
{
    public function setRomDataFromFile(Rom $rom, RomFile $romFile): void
    {
        $sql =
            DB::raw(/** @lang MariaDB */ "CALL LinkRomToFile(:fileId, :fileSize, :romId);");
        DB::statement($sql, [
            'fileId' => $romFile->getKey(),
            'fileSize' => $romFile->length,
            'romId' => $rom->getKey()
        ]);
        $rom->refresh();
    }


    public function linkRomToFileIfExists(Rom $rom): void
    {
        $romFile = RomRepo::searchForFileMatchingRom($rom->id);
        if (isset($romFile)) $this->setRomDataFromFile($rom, $romFile);
    }
}
