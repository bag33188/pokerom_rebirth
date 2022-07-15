<?php

namespace App\Repositories;

use App\Interfaces\Repository\RomRepositoryInterface;
use App\Models\Game;
use App\Models\Rom;
use App\Models\RomFile;
use App\Queries\RomQueriesTrait as RomQueries;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RomRepository implements RomRepositoryInterface
{
    use RomQueries;

    public function getSingleRomWithGameInfo(int $romId): Rom
    {
        return Rom::with('game')->where('id', '=', $romId)->firstOrFail();
    }

    public function getRomsWithGameAndFileInfo(): Collection
    {
        return Rom::with(['game', 'romFile'])->get();
    }

    public function findRomIfExists(int $romId): Rom
    {
        return Rom::findOrFail($romId);
    }

    public function getAllRomsSorted(): Collection
    {
        return Rom::all()->sortBy([['game_id', 'asc'], ['rom_size', 'asc']]);
    }

    public function getGameAssociatedWithRom(int $romId): Game
    {
        return $this->findRomIfExists($romId)->game()->firstOrFail();
    }

    public function getFileAssociatedWithRom(int $romId): RomFile
    {
        return $this->findRomIfExists($romId)->romFile()->firstOrFail();
    }

    public function searchForRomMatchingRomFile(RomFile $romFile): ?Rom
    {
        /*
            list($romName, $romExtension) =
                FileUtils::splitFilenameIntoParts($this->findRomFileIfExists($romFileId)->filename);
            return Rom::where([
                ['rom_name', '=', $romName, 'and'],
                ['rom_type', '=', $romExtension, 'and']
            ])->where(function (\Jenssegers\Mongodb\Helpers\EloquentBuilder $query) {
                $query
                    ->where('has_file', '=', FALSE)
                    ->orWhere('file_id', '=', NULL);
            })->limit(1)->first();
         */
        list($query, $bindings) = $this->findMatchingRomFromFilename($romFile->filename)->getValues();
        return Rom::fromQuery($query, $bindings)->first();
    }

    public function getFormattedRomSize(int $romSize): string
    {
        [$query, $bindings] = $this->formatRomSize($romSize)->getValues();
        return DB::selectOne($query, $bindings)->romSize;
    }

    public function getRomsCount(): int
    {
        $query = $this->countRomsInDatabase()->toArray()['query'];
        return DB::selectOne($query)->count;
    }
}
