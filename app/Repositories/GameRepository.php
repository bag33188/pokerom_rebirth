<?php
namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;
use App\Models\Game;

class GameRepository implements GameRepositoryInterface{
    public function associateGameWithRom($game, &$rom){
        $rom->refresh();
        $game->rom()->associate($rom);
        $game->save();
        return $game;
    }
    public function showRom(int $gameId) {
        return Game::findOrFail($gameId)->rom()->first();
    }
}
