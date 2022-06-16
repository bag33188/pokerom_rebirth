<?php

namespace App\Interfaces;

use App\Models\Game;
use App\Models\Rom;

interface GameRepositoryInterface
{

    public function showAssociatedRom(int $gameId);
}
