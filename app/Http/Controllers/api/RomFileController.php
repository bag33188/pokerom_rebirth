<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreRomFileRequest;
use App\Http\Resources\RomFileCollection;
use App\Http\Resources\RomFileResource;
use App\Http\Resources\RomResource;
use App\Interfaces\Action\RomFileActionsInterface;
use App\Interfaces\Service\RomFileServiceInterface;
use App\Models\RomFile;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse, Support\Collection};
use Illuminate\Support\Facades\Gate;
use RomFileRepo;
use Symfony\Component\HttpFoundation\StreamedResponse;


class RomFileController extends ApiController
{
    public function __construct(private readonly RomFileServiceInterface $romFileService)
    {
    }

    public function index(): RomFileCollection
    {
        Gate::authorize('viewAny-romFile');

        return new RomFileCollection(RomFileRepo::getAllRomFilesSorted());
    }

    /**
     * @throws AuthorizationException
     */
    public function indexRom(string $romFileId): RomResource
    {
        $romFile = RomFileRepo::findRomFileIfExists($romFileId);
        $this->authorize('view', $romFile);
        return new RomResource(RomFileRepo::getRomAssociatedWithFile($romFileId));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(string $romFileId)
    {
        $romFile = RomFileRepo::findRomFileIfExists($romFileId);
        $this->authorize('view', $romFile);
        return new RomFileResource($romFile);
    }

    /**
     * @param string $romFileId
     * @return StreamedResponse
     */
    public function download(string $romFileId): StreamedResponse
    {
        $romFile = RomFileRepo::findRomFileIfExists($romFileId);
        return $this->romFileService->downloadRomFile($romFile);
    }

    /**
     * @throws AuthorizationException
     */
    public function upload(StoreRomFileRequest $request): JsonResponse
    {
        $this->authorize('create', RomFile::class);

        return $this->romFileService->uploadRomFile($request['filename'])->renderResponse();
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $romFileId): JsonResponse
    {
        $romFile = RomFileRepo::findRomFileIfExists($romFileId);
        $this->authorize('delete', $romFile);
        return $this->romFileService->deleteRomFile($romFile)->renderResponse();
    }

    /**
     * @return string[]
     */
    public function listFilesInRomFilesStorage(RomFileActionsInterface $romFileActions): array
    {
        Gate::authorize('viewAny-romFile');

        return $romFileActions->listAllFilesInStorage();
    }

    /**
     * @return string[]
     */
    public function listRomsInRomFilesStorage(RomFileActionsInterface $romFileActions): array
    {
        Gate::authorize('viewAny-romFile');

        return $romFileActions->listRomFilesInStorage();
    }

    public function indexMetadata(): Collection
    {
        Gate::authorize('viewAny-romFile');
        return RomFileRepo::getRomeFilesMetadata();
    }
}
