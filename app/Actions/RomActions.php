<?php

namespace App\Actions;

use App\Interfaces\Action\RomActionsInterface;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomQueriesTrait;
use Illuminate\Support\Facades\DB;
use RomRepo;

class RomActions implements RomActionsInterface
{
    use RomQueriesTrait;

    public function setRomDataFromFile(Rom $rom, RomFile $romFile): void
    {
        [$query, $bindings] = $this->linkRomToFile($romFile->getKey(), $romFile->length, $rom->getKey())->getValues();
        $stmt = DB::statement($query, $bindings);
        if ($stmt) $rom->refresh();
    }

    public function linkRomToFileIfExists(Rom $rom): void
    {
        $romFile = RomRepo::searchForRomFileMatchingRom($rom->id);
        if (isset($romFile)) $this->setRomDataFromFile($rom, $romFile);
    }
}
