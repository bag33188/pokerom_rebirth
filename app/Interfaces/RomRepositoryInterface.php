<?php
namespace App\Interfaces;

use App\Models\Rom;

interface RomRepositoryInterface {
    public function linkRomToFile(Rom $rom);
}
