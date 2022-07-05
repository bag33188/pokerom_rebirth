<?php

namespace App\Services\GridFS\Queries\RomFiles;

use JetBrains\PhpStorm\ArrayShape;

trait CalcLengthKibibytes
{
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
}
