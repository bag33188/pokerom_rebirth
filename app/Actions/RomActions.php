<?php

namespace App\Actions;

use App\Interfaces\Action\RomActionsInterface;
use App\Models\Rom;
use App\Models\RomFile;
use Illuminate\Support\Facades\DB;
use RomRepo;

class RomActions implements RomActionsInterface
{
    public function setRomDataFromFile(Rom $rom, RomFile $romFile): void
    {
        $sql =
            /** @lang MariaDB */
            "CALL LinkRomToFile(:romFileId, :romFileSize, :romId);";
        $query = DB::raw($sql);
        DB::statement($query, [
            'romFileId' => $romFile->getKey(),
            'romFileSize' => $romFile->length,
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
