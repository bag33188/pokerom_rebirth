<?php

namespace App\Services\Api;

use App\Interfaces\Action\RomActionsInterface;
use App\Interfaces\Service\RomServiceInterface;
use App\Models\Rom;
use RomFileRepo;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Utils\Modules\JsonDataResponse;

class RomService implements RomServiceInterface
{
    private readonly RomActionsInterface $romActions;

    public function __construct(RomActionsInterface $romActions)
    {
        $this->romActions = $romActions;
    }

    public function attemptToLinkRomToRomFile(Rom $rom): JsonDataResponse
    {
        $romFile = RomFileRepo::findRomFileByFilename($rom->getRomFileName());
        if (isset($romFile)) {
            $this->romActions->setRomDataFromRomFileData($rom, $romFile);
            return new JsonDataResponse([
                'message' => "file found and linked! file id: {$romFile->getKey()}",
                'data' => $rom->refresh()
            ], HttpResponse::HTTP_OK);
        } else {
            return new JsonDataResponse([
                'message' => "File not found with name of {$rom->getRomFileName()}"
            ], HttpResponse::HTTP_NOT_FOUND);
        }
    }
}
