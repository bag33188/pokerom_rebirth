<?php

namespace App\Actions;

use App\Interfaces\Action\RomActionsInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomQueriesTrait as RomQueries;
use Illuminate\Support\Facades\DB;
use RomFileRepo;

class RomActions implements RomActionsInterface
{
    use RomQueries;

    public function setRomDataFromRomFileData(Rom $rom, RomFile $romFile): void
    {
        [$query, $bindings] = $this->updateRomFromRomFileData(
            $romFile->_id,
            $romFile->length,
            $rom->id
        )->getValues();
        $stmt = DB::statement($query, $bindings);
        if ($stmt) $rom->refresh();
    }

    public function linkRomToFileIfExists(Rom $rom): void
    {
        $romFile = RomFileRepo::findRomFileByFilename($rom->getRomFileName());
        if (isset($romFile)) $this->setRomDataFromRomFileData($rom, $romFile);
    }
}
