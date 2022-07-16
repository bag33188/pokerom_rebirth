<?php

namespace App\Queries;

use App\Models\RomFile;
use stdClass;

trait RomFileQueriesTrait
{
    private static function getAggregations(): stdClass
    {
        return require('aggregations.php');
    }

    /**
     * Returns result in `bytes`
     * @return int
     * @see DATA_BYTE_FACTOR
     */
    protected function romFileMaxLength(): int
    {
        return RomFile::max('length');
    }

    /**
     * Returns result in `bytes`
     * @return int
     * @see DATA_BYTE_FACTOR
     */
    protected function romFileSumLength(): int
    {
        return RomFile::sum('length');
    }

    protected function splitRomFilenamesIntoFileEntityValues(): array
    {
        return self::getAggregations()->split_rom_filenames;
    }

    protected function calcLengthsOfRomFilesKibibytes(): array
    {
        return self::getAggregations()->kibibyte_lengths;
    }
}
