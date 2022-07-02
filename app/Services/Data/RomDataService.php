<?php

namespace App\Services\Data;

use App\Interfaces\RomActionsInterface;
use App\Interfaces\RomDataServiceInterface;
use App\Models\Rom;
use RomRepo;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Utils\Modules\JsonDataResponse;

class RomDataService implements RomDataServiceInterface
{
    private RomActionsInterface $romActions;

    public function __construct(RomActionsInterface $romActions)
    {
        $this->romActions = $romActions;
    }

    public function attemptToLinkRomToFile(Rom $rom): JsonDataResponse
    {
        $romFile = RomRepo::searchForFileMatchingRom($rom->id);
        if (isset($romFile)) {
            $this->romActions->setRomDataFromFile($rom, $romFile);
            return new JsonDataResponse([
                'message' => "file found and linked! file id: {$romFile->getKey()}",
                'data' => $rom->refresh()
            ], ResponseAlias::HTTP_OK);
        } else {
            return new JsonDataResponse(['message' => "File not found with name of {$rom->getRomFileName()}"], ResponseAlias::HTTP_NOT_FOUND);
        }
    }
}
