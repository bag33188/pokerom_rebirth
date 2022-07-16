<?php

namespace App\Queries;

/*
 * |===================================|
 * | MongoDB Aggregations for RomFiles |
 * |===================================|
 */

use stdClass;

/**
 * @var stdClass
 */
$aggregations = (object)array(
    'kibibyteLengths' => [
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
    ],
    'splitFilenames' => [
        'fileEntities' => ['$split' => ['$filename', '.']],
        'length' => '$length',
        'chunkSize' => '$chunkSize'
    ]
);

return $aggregations;
