<?php

namespace App\Queries;

use App\Models\RomFile;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

trait RomFileQueriesTrait
{
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

    #[ArrayShape(['fileEntities' => "\string[][]", 'length' => "string", 'chunkSize' => "string"])]
    #[Pure]
    protected function splitRomFilenamesIntoFileEntities(): array
    {
        return [
            'fileEntities' => ['$split' => ['$filename', '.']],
            'length' => '$length',
            'chunkSize' => '$chunkSize'
        ];
    }

    #[Pure]
    #[ArrayShape(['length' => "array[]", 'filename' => "string", 'chunkSize' => "string"])]
    protected function calcLengthsOfRomFilesKibibytes(): array
    {
        return [
            'length' => [
                '$concat' => [
                    [
                        '$toString' => [
                            '$toInt' => [
                                '$ceil' => [
                                    '$divide' => [
                                        '$length',
                                        1024
                                    ]
                                ]
                            ]
                        ]
                    ],
                    _SPACE,
                    'KB'
                ]
            ],
            'filename' => '$filename',
            'chunkSize' => '$chunkSize'
        ];
    }
}
