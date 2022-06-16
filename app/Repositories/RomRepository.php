<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Interfaces\RomRepositoryInterface;
use App\Models\File;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Builder as QueryBuilder;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RomRepository implements RomRepositoryInterface
{
    private Rom $rom;

    public function __construct(Rom $rom)
    {
        $this->rom = $rom;
    }

    public function showAssociatedGame(int $romId): Game
    {
        $associatedGame = $this->rom->findOrFail($romId)->game()->firstOrFail();
        return $associatedGame;
    }

    /**
     * @throws NotFoundException
     */
    public function showAssociatedFile(int $romId): File
    {
        $associatedFile = $this->rom->findOrFail($romId)->file()->first();
        return $associatedFile ?? throw new NotFoundException('this rom does not have a file');
    }

    /**
     * This will attempt to cross-reference the MongoDB database and check if there is a file
     * with the same name of the roms name plus its extension (rom type)
     * @return QueryBuilder|null
     */
    public function searchForFileMatchingRom(): QueryBuilder|null
    {
        return File::where('filename', '=', $this->rom->getRomFileName());
    }
}