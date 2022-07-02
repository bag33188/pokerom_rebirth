<?php

namespace App\Observers;

use App\Models\Game;
use Illuminate\Support\Str;

class GameObserver
{
    public bool $afterCommit = false;

    /** @var bool Use database relationships to update models */
    private static bool $USE_DATABASE_LOGIC = true;

    private static function slugifyGameName(Game &$game): void
    {
        $gameName = $game->getAttributeValue('game_name');
        $game = $game->setAttribute('slug', Str::slug($gameName));
    }

    public function creating(Game $game): void
    {
        self::slugifyGameName($game);
    }

    public function created(Game $game): void
    {
        if (self::$USE_DATABASE_LOGIC === false) {
            $rom = $game->rom()->first();
            // use attribute syntax for proper non-fillable updating
            $rom['has_game'] = true;
            $rom['game_id'] = $game->id;
            $rom->saveQuietly();
        }
    }

    public function updating(Game $game): void
    {
        self::slugifyGameName($game);
    }

    public function deleted(Game $game): void
    {
        if (self::$USE_DATABASE_LOGIC === false) {
            $rom = $game->rom()->first();
            $rom['game_id'] = null;
            $rom['has_game'] = false;
            $rom->saveQuietly();
        }
    }
}
