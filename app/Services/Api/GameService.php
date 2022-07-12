<?php

namespace App\Services\Api;

use App\Interfaces\Service\GameServiceInterface;
use App\Models\Game;
use Date;
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
        return $rom->game()->create($gameData);
    }
}
