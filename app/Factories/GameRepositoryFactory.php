<?php

namespace App\Factories;

use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

interface GameRepositoryFactory
{
    public function getAllGamesSorted(): Collection;

    public function findGameIfExists(int $gameId): Game;

    public function getRomAssociatedWithGame(int $gameId): Rom;
}
