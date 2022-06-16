<?php
namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;

class GameRepository implements GameRepositoryInterface{
    public function associateGameWithRom(&$game, &$rom){
        $rom->refresh();
        $game->rom()->associate($rom);
        $game->save();
        return $game;
    }
}
