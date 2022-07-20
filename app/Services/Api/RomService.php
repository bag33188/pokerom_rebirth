<?php

namespace App\Services\Api;

use App\Interfaces\Service\RomServiceInterface;
use App\Models\Rom;
use App\Queries\RomQueriesTrait as RomQueries;
use RomFileRepo;

class RomService implements RomServiceInterface
{
    use RomQueries;

    // todo: used in observer
    public function linkRomToRomFileIfExists(Rom $rom): bool
    {
        $romFile = RomFileRepo::findRomFileByFilename($rom->getRomFileName());
        if (isset($romFile)) {
            [$query, $bindings] = ($this->updateRomFromRomFileData(
                $romFile->_id,
                $romFile->length,
                $rom->id
            ))();
            $stmt = \DB::statement($query, $bindings);
            if ($stmt === true) $rom->refresh();
            return $stmt;
        } else {
            return false;
        }
    }
}
