<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreRomFileRequest;
use App\Http\Resources\RomFileCollection;
use App\Http\Resources\RomFileResource;
use App\Http\Resources\RomResource;
use App\Interfaces\RomFileDataServiceInterface;
use App\Models\RomFile;
use RomFileRepo;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;


class RomFileController extends ApiController
{
    private RomFileDataServiceInterface $romFileDataService;

    public function __construct(RomFileDataServiceInterface $romFileDataService)
    {
        $this->romFileDataService = $romFileDataService;
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
    public function indexRom(string $fileId): RomResource
    {
        $romFile = RomFileRepo::findFileIfExists($fileId);
        $this->authorize('view', $romFile);
        return new RomResource(RomFileRepo::getRomAssociatedWithFile($fileId));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(string $fileId)
    {
        $romFile = RomFileRepo::findFileIfExists($fileId);
        $this->authorize('view', $romFile);
        return new RomFileResource($romFile);
    }

    /**
     * @param string $fileId
     * @return StreamedResponse
     */
    public function download(string $fileId): StreamedResponse
    {
        $romFile = RomFileRepo::findFileIfExists($fileId);
        return $this->romFileDataService->downloadFile($romFile);
    }

    /**
     * @throws AuthorizationException
     */
    public function upload(StoreRomFileRequest $request): JsonResponse
    {
        $this->authorize('create', RomFile::class);

        return $this->romFileDataService->uploadFile($request['filename'])->renderResponse();
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $fileId): JsonResponse
    {
        $romFile = RomFileRepo::findFileIfExists($fileId);
        $this->authorize('delete', $romFile);
        return $this->romFileDataService->deleteFile($romFile)->renderResponse();
    }
}
