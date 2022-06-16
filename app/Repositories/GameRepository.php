<?php

namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_Game_C;

class GameRepository implements GameRepositoryInterface
{
    private Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function findGameIfExists(int $gameId): array|_IH_Game_C|Game
    {
        return $this->game->findOrFail($gameId);
    }

    public function getAllGamesSorted(): Collection|array|_IH_Game_C
    {
        return $this->game->all()->sortBy([
            ['rom_id', 'asc'],
            ['generation', 'asc']
        ]);
    }

    public function getRomAssociatedWithGame(int $gameId): Rom
    {
        $associatedRom = $this->findGameIfExists($gameId)->rom()->first();
        return $associatedRom;
    }
}
