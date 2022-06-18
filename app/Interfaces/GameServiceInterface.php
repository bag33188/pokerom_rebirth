<?php

namespace App\Interfaces;

interface GameServiceInterface
{
    public function createGame(int $romId, array $data);
}
