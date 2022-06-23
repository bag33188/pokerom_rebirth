<?php

namespace App\Services;

use App\Interfaces\RomDataServiceInterface;
use App\Models\File;
use App\Models\Rom;
use Illuminate\Support\Facades\DB;
use RomRepo;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Utils\Modules\JsonDataResponse;

class RomDataService implements RomDataServiceInterface
{
    public function attemptToLinkRomToFile(Rom $rom): JsonDataResponse
    {
        $file = RomRepo::searchForFileMatchingRom($rom->id);
        if (isset($file)) {
            $this->setRomDataFromFile($rom, $file);
            return new JsonDataResponse([
                'message' => "file found and linked! file id: {$file->getKey()}",
                'data' => $rom->refresh()
            ], ResponseAlias::HTTP_OK);
        } else {
            return new JsonDataResponse(['message' => "File not found with name of {$rom->getRomFileName()}"], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    public function linkRomToFileIfExists(Rom $rom): void
    {
        $file = RomRepo::searchForFileMatchingRom($rom->id);
        if (isset($file)) $this->setRomDataFromFile($rom, $file);
    }

    private function setRomDataFromFile(Rom $rom, File $file): void
    {
        $sql = /** @lang MariaDB */
            "CALL LinkRomToFile(:fileId, :fileSize, :romId);";
        DB::statement($sql, [
            'fileId' => $file->getKey(),
            'fileSize' => $file['length'],
            'romId' => $rom->getKey()
        ]);
        $rom->refresh();
    }
}
