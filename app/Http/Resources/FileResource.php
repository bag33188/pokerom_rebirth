<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin File */
class FileResource extends JsonResource
{
    public $additional = ['success' => true];

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape(['_id' => "string", 'chunkSize' => "integer", 'filename' => "string", 'length' => "int", 'uploadDate' => "string", 'md5' => "string"])]
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
