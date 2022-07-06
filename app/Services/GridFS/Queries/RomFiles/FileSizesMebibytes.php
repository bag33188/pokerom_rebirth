<?php

namespace App\Services\GridFS\Queries\RomFiles;

use JetBrains\PhpStorm\ArrayShape;

trait FileSizesMebibytes
{
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
