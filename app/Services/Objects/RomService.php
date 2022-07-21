<?php

namespace App\Services\Objects;

use App\Interfaces\Service\RomServiceInterface;
use App\Models\Rom;
use App\Queries\RomQueriesTrait as RomQueries;
use DB;
use RomFileRepo;

class RomService implements RomServiceInterface
{
    use RomQueries {
        updateRomFromRomFileData as private;
    }

    public function linkRomToRomFileIfExists(Rom $rom): bool
    {
        $romFile = RomFileRepo::findRomFileByFilename($rom->getRomFileName());

        if (isset($romFile)) {
            $props = array($romFile->_id, $romFile->length, $rom->id);
            $dbCommand = $this->updateRomFromRomFileData(...$props)->toArray();
            extract($dbCommand);

            $stmt = DB::statement($query, $bindings);

            if ($stmt === true) $rom->refresh();

            return $stmt;
        } else {
            return false;
        }
    }
}
