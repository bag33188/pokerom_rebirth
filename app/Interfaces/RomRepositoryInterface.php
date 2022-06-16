<?php
namespace App\Interfaces;

use App\Models\Rom;

interface RomRepositoryInterface {
    public function linkRomToFile(Rom $rom);
    public function assocGame(int $romId);
    public function assocFile(int $romId);
}
