<?php

namespace App\Actions\Game;

use App\Models\Game;
use Illuminate\Support\Str;

class SlugifyGameName
{
    /**
     * Modifies a {@see Game `Game`} object and slugifies the {@see Game::game_name `game_name`} property
     * (sets `slug` field value).
     *
     * @param Game $game
     * @return void
     */
    public static function slugify(Game &$game): void
    {
        // uses get/set syntax instead of accessor syntax
        $gameName = $game->getAttributeValue('game_name');
        $game = $game->setAttribute('slug', Str::slug($gameName));
    }
}
