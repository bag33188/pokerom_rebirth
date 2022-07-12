<?php

namespace App\Queries;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/** RomFile Aggregations (MongoDB) */
trait RomFileAggregationsTrait
{
    #[Pure]
    #[ArrayShape(['length' => "array[]"])]
    protected function calcLengthsOfRomFilesGibibytes(): array
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

    #[Pure]
    #[ArrayShape(['length' => "array[]"])]
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
            ]
        ];
    }

    #[Pure]
    #[ArrayShape(['length' => "array[]"])]
    protected function calcLengthsOfRomFilesMebibytes(): array
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
                                3
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
