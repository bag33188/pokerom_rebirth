<?php

namespace App\Services\Objects;

use App\Interfaces\Service\GameServiceInterface;
use App\Models\Game;
use Illuminate\Support\Facades\Date;
use JetBrains\PhpStorm\ArrayShape;
use RomRepo;

class GameService implements GameServiceInterface
{
    private const GAME_DATA_SHAPE = [
        "game_name" => "string",
        "game_type" => "string",
        "date_released" => Date::class,
        "generation" => "int",
        "region" => "string"
    ];


    public function createGameFromRomId(int $romId, #[ArrayShape(self::GAME_DATA_SHAPE)] array $gameData): Game
    {
        $rom = RomRepo::findRomIfExists($romId);
        // create resource with embed relationship
        return $rom->game()->create($gameData);
    }
}
