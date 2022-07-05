<?php

namespace App\Services\GridFS\Queries\RomFiles;

use JetBrains\PhpStorm\ArrayShape;

trait CalcLengthGibibytes
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
}
