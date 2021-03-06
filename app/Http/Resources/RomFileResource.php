<?php

namespace App\Http\Resources;

use App\Models\RomFile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin RomFile */
class RomFileResource extends JsonResource
{
    private const ROMFILE_SHAPE = [
        '_id' => "string",
        'chunkSize' => "int",
        'filename' => "string",
        'length' => "int",
        'uploadDate' => "string",
        'md5' => "string"
    ];
    public $additional = ['success' => true];

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape(self::ROMFILE_SHAPE)]
    public function toArray($request): array
    {
        return [
            '_id' => $this->_id,
            'chunkSize' => $this->chunkSize,
            'filename' => $this->filename,
            'length' => $this->length,
            'uploadDate' => $this->uploadDate,
            'md5' => $this->md5
        ];
    }
}
