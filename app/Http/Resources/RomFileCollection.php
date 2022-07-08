<?php

namespace App\Http\Resources;

use App\Models\RomFile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin RomFile */
class RomFileCollection extends ResourceCollection
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
