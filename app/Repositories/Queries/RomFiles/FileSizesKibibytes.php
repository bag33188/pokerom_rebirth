<?php

namespace App\Repositories\Queries\RomFiles;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

trait FileSizesKibibytes
{
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
}
