<?php

namespace App\Queries;

use App\Models\RomFile;
use stdClass;

trait RomFileQueriesTrait
{
    private function getAggregations(): stdClass
    {
        return require('aggregations.php');
    }

    /**
     * Returns result in `bytes`
     * @return int
     * @see RomFile::DATA_BYTE_FACTOR
     */
    protected function romFileMaxLength(): int
    {
        return RomFile::max('length');
    }

    /**
     * Returns result in `bytes`
     * @return int
     * @see RomFile::DATA_BYTE_FACTOR
     */
    protected function romFileSumLength(): int
    {
        return RomFile::sum('length');
    }

    protected function splitRomFilenamesIntoFileEntityValues(): array
    {
        return $this->getAggregations()->splitFilenames;
    }

    protected function calcLengthsOfRomFilesKibibytes(): array
    {
        return $this->getAggregations()->kibibyteLengths;
    }
}
