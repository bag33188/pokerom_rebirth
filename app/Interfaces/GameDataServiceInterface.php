<?php

namespace App\Interfaces;

use App\Http\Resources\GameResource;

interface GameDataServiceInterface
{
    public function createGame(int $romId, array $data): GameResource;
}
