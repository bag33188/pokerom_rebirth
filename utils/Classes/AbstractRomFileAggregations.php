<?php

namespace Utils\Classes;

use App\Models\RomFile;
use stdClass;

/**
 * MongoDB Aggregation Pipeline for {@see RomFile RomFile} resource collection.
 *
 * Properties:
 *   - {@see AbstractRomFileAggregations::$kibibyte_lengths kibibyte_lengths}
 *   - {@see AbstractApplicationException::$split_rom_filenames split_rom_filenames}
 */
abstract class AbstractRomFileAggregations extends stdClass
{
    /**
     * retrieves all documents in collection but converts the {@see AbstractGridFSModel::$length length} property
     * to Kibibytes (base {@link DATA_BYTE_FACTOR 1024} bytes)
     * @var array $kibibyte_lengths
     */
    public readonly array $kibibyte_lengths;
    /**
     * retrieves all documents but projects the {@see AbstractGridFSModel::$filename filename} into an array
     * with the file's name and the file's type as array items.
     * @var array $split_rom_filenames
     */
    public readonly array $split_rom_filenames;
}
