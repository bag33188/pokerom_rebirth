<?php

namespace App\Http\Controllers\api;

use App\Enums\FileTypesEnum as FileTypes;
use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreFileRequest;
use App\Interfaces\FileServiceInterface;
use App\Models\File;
use FileRepo;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;


class FileController extends ApiController
{
    private FileServiceInterface $fileService;

    public function __construct(FileServiceInterface $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        Gate::authorize('viewAny-file');
        return response()->json(FileRepo::getAllFilesSorted());
    }

    /**
     * @throws AuthorizationException
     */
    public function indexRom(string $fileId): JsonResponse
    {
        $file = FileRepo::findFileIfExists($fileId);
        $this->authorize('view', $file);
        return response()->json(FileRepo::getRomAssociatedWithFile($fileId));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(string $fileId)
    {
        $file = FileRepo::findFileIfExists($fileId);
        $this->authorize('view', $file);
        return response()->json($file);
    }

    /**
     * @param string $fileId
     * @return StreamedResponse
     */
    public function download(string $fileId): StreamedResponse
    {
        $file = FileRepo::findFileIfExists($fileId);
        return $this->fileService->downloadFile($file);
    }

    /**
     * @throws AuthorizationException
     */
    public function upload(StoreFileRequest $request): JsonResponse
    {
        $this->authorize('create', File::class);
        $file = $request->file(FILE_FORM_KEY);

        return $this->fileService->uploadFile($file)->response()->header('X-Content-Transfer-Type', FileTypes::X_BINARY->value);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $fileId): JsonResponse
    {
        $file = FileRepo::findFileIfExists($fileId);
        $this->authorize('delete', $file);
        return $this->fileService->deleteFile($file)->response();
    }
}
