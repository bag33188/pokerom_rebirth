<?php

namespace App\Queries;

/*
 * |===================================|
 * | MongoDB Aggregations for RomFiles |
 * |===================================|
 */

use stdClass;

/** @var stdClass $rom_file_aggregations */
$rom_file_aggregations = (object)array(
    'kibibyte_lengths' => [
        'length' => [
            '$concat' => [
                [
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
                ],
                _SPACE,
                'KB'
            ]
        ],
        'filename' => '$filename',
        'chunkSize' => '$chunkSize'
    ],
    'split_rom_filenames' => [
        'fileEntities' => [
            '$split' => [
                '$filename',
                '.'
            ]
        ],
        'length' => '$length',
        'chunkSize' => '$chunkSize'
    ]
);

return $rom_file_aggregations;
