<?php

namespace App\Http\Resources;

use Utils\Classes\AbstractGridFsFile as GfsFile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin GfsFile */
class FileCollection extends ResourceCollection
{
    public $additional = ['success' => true];

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape(['data' => "\Illuminate\Support\Collection"])]
    public function toArray($request): array
    {
        return ['data' => $this->collection];
    }
}
