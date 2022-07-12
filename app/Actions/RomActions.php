<?php

namespace App\Actions;

use App\Interfaces\Action\RomActionsInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomQueriesTrait;
use Illuminate\Support\Facades\DB;
use RomFileRepo;

class RomActions implements RomActionsInterface
{
    use RomQueriesTrait;

    public function setRomDataFromRomFileData(Rom $rom, RomFile $romFile): void
    {
        [$query, $bindings] = $this->linkRomToFile($romFile->getKey(), $romFile->length, $rom->getKey())->getValues();
        $stmt = DB::statement($query, $bindings);
        if ($stmt) $rom->refresh();
    }

    public function linkRomToFileIfExists(Rom $rom): void
    {
        $romFile = RomFileRepo::getRomFileByFilename($rom->getRomFileName());
        if (isset($romFile)) $this->setRomDataFromRomFileData($rom, $romFile);
    }
}
