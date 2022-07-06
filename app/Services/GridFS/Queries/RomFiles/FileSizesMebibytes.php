<?php

namespace App\Services\GridFS\Queries\RomFiles;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

trait FileSizesMebibytes
{
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
