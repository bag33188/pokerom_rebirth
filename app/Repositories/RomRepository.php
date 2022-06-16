<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Interfaces\RomRepositoryInterface;
use App\Models\File;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RomRepository implements RomRepositoryInterface
{
    /**
     * @throws NotFoundException
     */
    #[ArrayShape(['message' => "string", 'data' => "\App\Models\Rom"])]
    public function tryToLinkRomToFile(Rom $rom): array
    {
        $file = $rom->searchForFileMatchingRom()->first();
        if (isset($file)) {
            DB::statement(/** @lang MariaDB */ "CALL LinkRomToFile(:fileId, :fileSize, :romId);", [
                'fileId' => $file['_id'],
                'fileSize' => $file->length,
                'romId' => $rom->id
            ]);
            $rom->refresh();
            return [
                'message' => "file found and linked! file id: {$file['_id']}",
                'data' => $rom->refresh()
            ];
        } else {
            throw new NotFoundException("File not found with name of {$rom->getRomFileName()}", ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    public function showAssociatedGame(int $romId): Game
    {
        $associatedGame = Rom::findOrFail($romId)->game()->firstOrFail();
        return $associatedGame;
    }

    /**
     * @throws NotFoundException
     */
    public function showAssociatedFile(int $romId): File
    {
        $associatedFile = Rom::findOrFail($romId)->file()->first();
        return $associatedFile ?? throw new NotFoundException('this rom does not have a file');
    }
}
