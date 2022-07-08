<?php

namespace App\Repositories\Queries\RomFiles;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

trait FileSizesGibibytes
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
}
