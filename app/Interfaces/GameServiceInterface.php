<?php

namespace App\Interfaces;

use Classes\JsonDataServiceResponse;

interface GameServiceInterface
{
    public function createGame(int $romId, array $data): JsonDataServiceResponse;
}
