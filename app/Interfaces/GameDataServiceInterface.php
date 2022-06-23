<?php

namespace App\Interfaces;

use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Model;

interface GameDataServiceInterface
{
    public function associateRomWithGame(Rom $rom, Game $game): void;

    public function createGameFromRomId(int $romId, array $data): Model|Game;
}
