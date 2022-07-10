<?php

namespace App\Interfaces\Action;

use App\Models\Game;

interface GameActionsInterface
{
    public function slugifyGameName(Game &$game): void;
}
