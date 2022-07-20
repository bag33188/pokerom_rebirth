<?php

namespace App\Services\Api;

use App\Interfaces\Service\GameServiceInterface;
use App\Models\Game;
use Date;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use RomRepo;

class GameService implements GameServiceInterface
{
    protected final const GAME_DATA_SHAPE = [
        "game_name" => "string",
        "game_type" => "string",
        "date_released" => \Illuminate\Support\Facades\Date::class,
        "generation" => "int",
        "region" => "string"
    ];

    /**
     * @param int $romId
     * @param array{game_name: string, game_type: string, region: string, generation: int, date_released: Date} $gameData
     * @return Game
     */
    public function createGameFromRomId(int $romId, #[ArrayShape(self::GAME_DATA_SHAPE)] array $gameData): Game
    {
        $rom = RomRepo::findRomIfExists($romId);
        $game = $rom->game()->create($gameData);
        return $game;
    }

    /**
     * Modifies a {@see Game `Game`} object and slugifies the {@see Game::game_name `game_name`} property
     * (sets `slug` field value).
     *
     * @param Game $game
     * @return void
     */
    public function slugifyGameName(Game &$game): void // todo: make action
    {
        // uses get/set syntax instead of accessor syntax
        $gameName = $game->getAttributeValue('game_name');
        $game = $game->setAttribute('slug', Str::slug($gameName));
    }
}
