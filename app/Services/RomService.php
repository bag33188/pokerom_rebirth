<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Interfaces\RomRepositoryInterface;
use App\Models\Rom;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RomService {
    private RomRepositoryInterface $romRepository;
    private Rom $rom;

    public function __construct(Rom $rom, RomRepositoryInterface $romRepository)
    {
        $this->rom = $rom;
        $this->romRepository = $romRepository;
    }

    /**
     * @throws NotFoundException
     */
    #[ArrayShape(['message' => "string", 'data' => "\App\Models\Rom"])]
    public function tryToLinkRomToFile(): array
    {
        $file = $this->romRepository->searchForFileMatchingRom()->first();
        if (isset($file)) {
            DB::statement(/** @lang MariaDB */ "CALL LinkRomToFile(:fileId, :fileSize, :romId);", [
                'fileId' => $file['_id'],
                'fileSize' => $file->length,
                'romId' => $this->rom->id
            ]);
            $this->rom->refresh();
            return [
                'message' => "file found and linked! file id: {$file['_id']}",
                'data' => $this->rom->refresh()
            ];
        } else {
            throw new NotFoundException("File not found with name of {$this->rom->getRomFileName()}", ResponseAlias::HTTP_NOT_FOUND);
        }
    }
}
