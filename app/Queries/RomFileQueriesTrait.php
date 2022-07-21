<?php

namespace App\Queries;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

trait RomFileQueriesTrait
{
    /**
     * @param string[] $columns Available columns: filename, filetype, filesize
     * @return Collection
     */
    protected function queryRomFileMetadata(array $columns): Collection
    {
        return DB::connection('mongodb')
            ->table('rom_files.info') // <- document collection
            ->get($columns)
            ->sortBy(['filesize', 'filename']);
    }

    /**
     * projects the {@see AbstractGridFSModel::$filename filename} into an array
     * with the file's name and the file's type as array items.
     * @return array
     */
    #[ArrayShape(['fileEntities' => "string[][]", 'length' => "string", 'chunkSize' => "string"])]
    protected function splitRomFilenamesIntoFileEntityValues(): array
    {
        return [
            'fileEntities' => [
                '$split' => [
                    '$filename',
                    '.'
                ]
            ],
            'length' => '$length',
            'chunkSize' => '$chunkSize'
        ];
    }

    /**
     * converts the {@see AbstractGridFSModel::$length length} property
     * to Kibibytes (base {@see DATA_BYTE_FACTOR 1024} bytes)
     * @return array
     */
    #[ArrayShape(['length' => "array[]", 'filename' => "string", 'chunkSize' => "string"])]
    protected function calcLengthsOfRomFilesKibibytes(): array
    {
        return [
            'length' => [
                '$concat' => [
                    array(
                        '$toString' => [
                            '$toInt' => [
                                '$ceil' => [
                                    '$divide' => [
                                        '$length',
                                        DATA_BYTE_FACTOR
                                    ]
                                ]
                            ]
                        ]
                    ),
                    _SPACE,
                    'KB'
                ]
            ],
            'filename' => '$filename',
            'chunkSize' => '$chunkSize'
        ];
    }

    /**
     * ### Sort By:
     *
     * ```
     * length => 1,
     * filename => 1
     * ```
     *
     * @return string[][]
     */
    protected function sortByLengthAscFilenameAsc(): array
    {
        return array(
            ['length', 'asc'],
            ['filename', 'asc']
        );
    }
}
