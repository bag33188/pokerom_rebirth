<?php

namespace App\Interfaces;

use App\Models\Game;
use Illuminate\Database\Eloquent\Model;

interface GameDataServiceInterface
{
    public function createGameFromRomId(int $romId, array $data): Model|Game;
}
