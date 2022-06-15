<?php

namespace App\Observers;

use App\Models\Game;
use Illuminate\Support\Str;

class GameObserver
{
    public bool $afterCommit = false;

    private static function slugify(Game $game): void
    {
        $gameName = $game->getAttributeValue('game_name');
        $game->setAttribute('slug', Str::slug($gameName));
    }

    public function creating(Game $game): void
    {
        self::slugify($game);
    }

    public function created(Game $game): void
    {
        // delete this functionality because trigger was added to db???
        $rom = $game->rom()->first();
        $rom['has_game'] = true;
        $rom['game_id'] = $game->id;
        $rom->saveQuietly();
    }

    public function updating(Game $game): void
    {
        self::slugify($game);
    }

    public function deleted(Game $game): void
    {
        // delete this functionality because trigger was added to db???
        $rom = $game->rom()->first();
        $rom['game_id'] = null;
        $rom['has_game'] = false;
        $rom->saveQuietly();
    }
}
