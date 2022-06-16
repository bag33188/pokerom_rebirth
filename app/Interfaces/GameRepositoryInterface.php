<?php

namespace App\Interfaces;

interface GameRepositoryInterface{
    public function associateGameWithRom($game, &$rom);
    public function showRom(int $gameId);
}
