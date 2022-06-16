<?php

namespace App\Services;

use App\Interfaces\GameServiceInterface;
use App\Models\Game;
use App\Models\Rom;

class GameService implements GameServiceInterface {
    private Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }
    public function associateGameWithRom(Rom &$rom): Game
    {
        $rom = $rom->refresh();
        $this->game->rom()->associate($rom);
        $this->game->save();
        return $this->game;
    }
}
