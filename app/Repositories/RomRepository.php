<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Interfaces\RomRepositoryInterface;
use App\Models\File;
use App\Models\Game;
use App\Models\Rom;
use Illuminate\Support\Facades\DB;

class RomRepository implements RomRepositoryInterface
{
    /**
     * @throws NotFoundException
     */
    public function linkRomToFile(Rom $rom)
    {
        $file = $rom->getFileMatchingRom()->first();
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
            throw new NotFoundException("File not found with name of {$rom->getRomFileName()}");
        }
    }

    public function showGame(int $romId): Game
    {
        return Rom::findOrFail($romId)->game()->firstOrFail();
    }

    /**
     * @throws NotFoundException
     */
    public function showFile(int $romId): File
    {
        $file = Rom::findOrFail($romId)->file()->first();
        return $file ?? throw new NotFoundException('this rom does not have a file');
    }
}
