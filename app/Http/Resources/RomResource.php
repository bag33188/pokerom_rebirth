<?php

namespace App\Http\Resources;

use App\Models\Rom;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Rom */
class RomResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'file_id' => $this->file_id,
            'game_id' => $this->game_id,
            'rom_name' => $this->rom_name,
            'rom_size' => $this->rom_size,
            'rom_type' => $this->rom_type,
            'has_game' => $this->has_game,
            'has_file' => $this->has_file,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'game' => new GameResource($this->whenLoaded('game')),
        ];
    }
}
