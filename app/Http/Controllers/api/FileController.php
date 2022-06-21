<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreFileRequest;
use App\Http\Resources\FileCollection;
use App\Http\Resources\FileResource;
use App\Http\Resources\RomResource;
use App\Interfaces\FileDataServiceInterface;
use App\Models\File;
use FileRepo;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;


class FileController extends ApiController
{
    private FileDataServiceInterface $fileDataService;

    public function __construct(FileDataServiceInterface $fileDataService)
    {
        $this->fileDataService = $fileDataService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): FileCollection
    {
        Gate::authorize('viewAny-file');
        return new FileCollection(FileRepo::getAllFilesSorted());
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
        return new FileResource($file);
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
    public function upload(StoreFileRequest $request): JsonResponse
    {
        $this->authorize('create', File::class);
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
