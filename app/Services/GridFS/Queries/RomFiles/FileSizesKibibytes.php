<?php

namespace App\Services\GridFS\Queries\RomFiles;

use JetBrains\PhpStorm\ArrayShape;

trait FileSizesKibibytes
{
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
