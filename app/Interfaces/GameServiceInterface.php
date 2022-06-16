<?php

namespace App\Interfaces;

use App\Models\Rom;

interface GameServiceInterface{
    public function associateGameWithRom(Rom &$rom);
}
