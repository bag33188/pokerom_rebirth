<?php

namespace App\Services\GridFS;

use JetBrains\PhpStorm\ArrayShape;

trait RomFilesAggregationsTrait
{
    #[ArrayShape(['length' => "array[]"])]
    protected function calcLengthGibibytes(): array
    {
        return [
            'length' => [
                '$concat' => [
                    [
                        '$toString' => [
                            '$round' => [
                                [
                                    '$toDecimal' => [
                                        '$divide' => [
                                            '$length',
                                            [
                                                '$pow' => [
                                                    1024,
                                                    2
                                                ]
                                            ]
                                        ]
                                    ]
                                ],
                                2
                            ]
                        ]
                    ],
                    _SPACE,
                    'GB'
                ]
            ]
        ];
    }

    #[ArrayShape(['length' => "array[]"])]
    protected function calcLengthKibibytes(): array
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
            ]
        ];
    }

    #[ArrayShape(['length' => "array[]"])]
    protected function calcLengthMebibytes(): array
    {
        return [
            'length' => [
                '$concat' => [
                    [
                        '$toString' => [
                            '$round' => [
                                [
                                    '$toDouble' => [
                                        '$divide' => [
                                            '$length',
                                            [
                                                '$pow' => [
                                                    1024,
                                                    3
                                                ]
                                            ]
                                        ]
                                    ]
                                ],
                                2
                            ]
                        ]
                    ],
                    _SPACE,
                    'MB'
                ]
            ]
        ];
    }
}
