<?php

namespace App\Services\GridFS\Queries\RomFiles;

use JetBrains\PhpStorm\ArrayShape;

trait FileSizeKibibytes
{
    #[ArrayShape(['length' => "array[]"])]
    protected function calcLengthOfRomFilesKibibytes(): array
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
