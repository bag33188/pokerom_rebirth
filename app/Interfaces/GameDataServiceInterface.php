<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface GameDataServiceInterface
{
    public function createGame(int $romId, array $data): JsonResponse;
}
