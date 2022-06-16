<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Rom;

class GameService {
    private Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }
    public function associateGameWithRom(Game $game, Rom &$rom): Game
    {
        $rom = $rom->refresh();
        $game->rom()->associate($rom);
        $game->save();
        return $game;
    }
}
