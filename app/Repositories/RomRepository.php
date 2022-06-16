<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Interfaces\RomRepositoryInterface;
use App\Models\Rom;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RomRepository implements RomRepositoryInterface
{
    /**
     * @throws NotFoundException
     */
    public function linkRomToFile(Rom $rom)
    {
        $file = $rom->checkMatchingFile()->first();
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

    public function assocGame(int $romId)
    {
        return Rom::findOrFail($romId)->game()->firstOrFail();
    }

    public function assocFile(int $romId)
    {
        $file = Rom::findOrFail($romId)->file()->first();
        return [$file ?? ['message' => 'this rom does not have a file'],
            isset($file) ? ResponseAlias::HTTP_OK : 404];
    }
}
