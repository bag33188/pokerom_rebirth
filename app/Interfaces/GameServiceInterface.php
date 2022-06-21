<?php

namespace App\Interfaces;

use App\Services\JsonServiceResponse;

interface GameServiceInterface
{
    public function createGame(int $romId, array $data): JsonServiceResponse;
}
