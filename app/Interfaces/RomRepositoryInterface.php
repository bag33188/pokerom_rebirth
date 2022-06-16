<?php

namespace App\Interfaces;

use App\Models\Rom;

interface RomRepositoryInterface
{
    public function linkRomToFile(Rom $rom);

    public function showGame(int $romId);

    public function showFile(int $romId);
}
