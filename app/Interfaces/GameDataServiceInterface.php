<?php

namespace App\Interfaces;

use Utils\Classes\JsonDataServiceResponse;

interface GameDataServiceInterface
{
    public function createGame(int $romId, array $data): JsonDataServiceResponse;
}
