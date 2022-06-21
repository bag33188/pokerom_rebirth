<?php

namespace App\Interfaces;

use Utils\Classes\JsonDataResponse;

interface GameDataServiceInterface
{
    public function createGame(int $romId, array $data): JsonDataResponse;
}
