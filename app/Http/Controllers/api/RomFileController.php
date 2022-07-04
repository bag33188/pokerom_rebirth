<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreRomFileRequest;
use App\Http\Resources\RomFileCollection;
use App\Http\Resources\RomFileResource;
use App\Http\Resources\RomResource;
use App\Interfaces\Service\RomFileDataServiceInterface;
use App\Models\RomFile;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Illuminate\Support\Facades\Gate;
use RomFileRepo;
use Symfony\Component\HttpFoundation\StreamedResponse;


class RomFileController extends ApiController
{

    public function __construct(private readonly RomFileDataServiceInterface $romFileDataService)
    {
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): RomFileCollection
    {
        Gate::authorize('viewAny-romFile');

        return new RomFileCollection(RomFileRepo::getAllFilesSorted());
    }

    /**
     * @throws AuthorizationException
     */
    public function indexRom(string $romFileId): RomResource
    {
        $romFile = RomFileRepo::findFileIfExists($romFileId);
        $this->authorize('view', $romFile);
        return new RomResource(RomFileRepo::getRomAssociatedWithFile($romFileId));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(string $romFileId)
    {
        $romFile = RomFileRepo::findFileIfExists($romFileId);
        $this->authorize('view', $romFile);
        return new RomFileResource($romFile);
    }

    /**
     * @param string $romFileId
     * @return StreamedResponse
     */
    public function download(string $romFileId): StreamedResponse
    {
        $romFile = RomFileRepo::findFileIfExists($romFileId);
        return $this->romFileDataService->downloadRomFile($romFile);
    }

    /**
     * @throws AuthorizationException
     */
    public function upload(StoreRomFileRequest $request): JsonResponse
    {
        $this->authorize('create', RomFile::class);

        return $this->romFileDataService->uploadRomFile($request['filename'])->renderResponse();
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $romFileId): JsonResponse
    {
        $romFile = RomFileRepo::findFileIfExists($romFileId);
        $this->authorize('delete', $romFile);
        return $this->romFileDataService->deleteRomFile($romFile)->renderResponse();
    }
}
