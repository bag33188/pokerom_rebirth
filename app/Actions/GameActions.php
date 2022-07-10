<?php

namespace App\Actions;

use App\Interfaces\Action\GameActionsInterface;
use App\Models\Game;
use Illuminate\Support\Str;

class GameActions implements GameActionsInterface
{
    /**
     * Modifies a {@see Game Game} object and slugify the `game_name` property (set `slug` field value).
     *
     * @param Game $game
     * @return void
     */
    public function slugifyGameName(Game &$game): void
    {
        // uses get/set syntax instead of accessor syntax
        $gameName = $game->getAttributeValue('game_name');
        $game = $game->setAttribute('slug', Str::slug($gameName));
    }
}