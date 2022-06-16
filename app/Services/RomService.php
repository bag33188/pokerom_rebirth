<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Interfaces\RomRepositoryInterface;
use App\Interfaces\RomServiceInterface;
use App\Models\Rom;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RomService implements RomServiceInterface {
    private RomRepositoryInterface $romRepository;

    public function __construct(RomRepositoryInterface $romRepository)
    {
        $this->romRepository = $romRepository;
    }

    /**
     * @throws NotFoundException
     */
    #[ArrayShape(['message' => "string", 'data' => "\App\Models\Rom"])]
    public function attemptToLinkRomToFile(Rom $rom): array
    {
        $file = $this->romRepository->searchForFileMatchingRom($rom->id)->first();
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
}
