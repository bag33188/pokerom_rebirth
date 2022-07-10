<?php

namespace App\Actions;

use App\Interfaces\Action\GameActionsInterface;
use App\Models\Game;
use Illuminate\Support\Str;

class GameActions implements GameActionsInterface
{
    public function slugifyGameName(Game &$game): void
    {
        $gameName = $game->getAttributeValue('game_name');
        $game = $game->setAttribute('slug', Str::slug($gameName));
    }
}
