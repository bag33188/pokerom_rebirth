<?php

namespace App\Services;

use App\Interfaces\RomRepositoryInterface;
use App\Interfaces\RomServiceInterface;
use App\Models\File;
use App\Models\Rom;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RomService implements RomServiceInterface
{
    private RomRepositoryInterface $romRepository;

    public function __construct(RomRepositoryInterface $romRepository)
    {
        $this->romRepository = $romRepository;
    }

    #[ArrayShape(['message' => "string", 'data' => "\App\Models\Rom"])]
    public function attemptToLinkRomToFile(Rom $rom): array
    {
        $file = $this->romRepository->searchForFileMatchingRom($rom->id);
        if (isset($file)) {
            $this->setRomDataFromFile($rom, $file);
            return [
                'message' => "file found and linked! file id: {$file['_id']}",
                'data' => $rom->refresh()
            ];
        } else {
            abort(ResponseAlias::HTTP_NOT_FOUND, "File not found with name of {$rom->getRomFileName()}");
        }
    }

    public function linkRomToFileIfExists(Rom $rom): void
    {
        $file = $this->romRepository->searchForFileMatchingRom($rom->id);
        if (isset($file)) $this->setRomDataFromFile($rom, $file);
    }

    private function setRomDataFromFile(Rom $rom, File $file)
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
