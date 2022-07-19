<?php

namespace App\Actions;

use App\Interfaces\Action\RomActionsInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomQueriesTrait as RomQueries;
use DB;
use RomFileRepo;

class RomActions implements RomActionsInterface
{
    use RomQueries;

    public function setRomDataFromRomFileData(Rom $rom, RomFile $romFile): bool
    {
        [$query, $bindings] = ($this->updateRomFromRomFileData(
            $romFile->_id,
            $romFile->length,
            $rom->id
        ))();
        $stmt = DB::statement($query, $bindings);
        if ($stmt === true) $rom->refresh();
        return $stmt;
    }

    public function linkRomToRomFileIfExists(Rom $rom): bool
    {
        $romFile = RomFileRepo::findRomFileByFilename($rom->getRomFileName());
        if (isset($romFile)) {
            return $this->setRomDataFromRomFileData($rom, $romFile);
        } else {
            return false;
        }
    }
}
