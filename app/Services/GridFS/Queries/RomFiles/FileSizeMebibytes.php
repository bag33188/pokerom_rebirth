<?php

namespace App\Services\GridFS\Queries\RomFiles;

use JetBrains\PhpStorm\ArrayShape;

trait FileSizeMebibytes
{
    #[ArrayShape(['length' => "array[]"])]
    protected function calcLengthOfRomFilesMebibytes(): array
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
