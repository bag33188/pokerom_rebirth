<?php

namespace App\Interfaces;

use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;

interface GameRepositoryInterface
{
    public function getAllGamesSorted(): Collection;

    public function findGameIfExists(int $gameId): Game;

    public function getRomAssociatedWithGame(int $gameId): Rom;

    public function getProperGameType(string $gameType): string;
}
