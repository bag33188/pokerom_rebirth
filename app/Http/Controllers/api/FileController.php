<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreRomFileRequest;
use App\Http\Resources\RomFileCollection;
use App\Http\Resources\RomFileResource;
use App\Http\Resources\RomResource;
use App\Interfaces\RomFileDataServiceInterface;
use App\Models\RomFile;
use FileRepo;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;


class FileController extends ApiController
{
    private RomFileDataServiceInterface $fileDataService;

    public function __construct(RomFileDataServiceInterface $fileDataService)
    {
        $this->fileDataService = $fileDataService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): RomFileCollection
    {
        Gate::authorize('viewAny-file');
        return new RomFileCollection(FileRepo::getAllFilesSorted());
    }

    /**
     * @throws AuthorizationException
     */
    public function indexRom(string $fileId): RomResource
    {
        $file = FileRepo::findFileIfExists($fileId);
        $this->authorize('view', $file);
        return new RomResource(FileRepo::getRomAssociatedWithFile($fileId));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(string $fileId)
    {
        $file = FileRepo::findFileIfExists($fileId);
        $this->authorize('view', $file);
        return new RomFileResource($file);
    }

    /**
     * @param string $fileId
     * @return StreamedResponse
     */
    public function download(string $fileId): StreamedResponse
    {
        $file = FileRepo::findFileIfExists($fileId);
        return $this->fileDataService->downloadFile($file);
    }

    /**
     * @throws AuthorizationException
     */
    public function upload(StoreRomFileRequest $request): JsonResponse
    {
        $this->authorize('create', RomFile::class);
        $file = $request->file(FILE_FORM_KEY);

        return $this->fileDataService->uploadFile($file)->renderResponse();
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $fileId): JsonResponse
    {
        $file = FileRepo::findFileIfExists($fileId);
        $this->authorize('delete', $file);
        return $this->fileDataService->deleteFile($file)->renderResponse();
    }
}
