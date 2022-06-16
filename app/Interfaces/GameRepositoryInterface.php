<?php

namespace App\Interfaces;

interface GameRepositoryInterface
{
    public function getAllGamesSorted();

    public function findGameIfExists(int $gameId);

    public function getRomAssociatedWithGame(int $gameId);
}
