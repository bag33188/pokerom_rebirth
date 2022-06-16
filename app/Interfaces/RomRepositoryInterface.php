<?php

namespace App\Interfaces;

interface RomRepositoryInterface
{
    public function getAllRomsSorted();

    public function findRomIfExists(int $romId);

    public function getGameAssociatedWithRom(int $romId);
    public function searchForFileMatchingRom(int $romId);
    public function getFileAssociatedWithRom(int $romId);
}
