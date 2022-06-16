<?php

namespace App\Http\Controllers\api;

use App\Enum\FileTypesEnum as FileTypes;
use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreFileRequest;
use App\Interfaces\FileRepositoryInterface;
use App\Models\File;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse, Http\Response};
use Illuminate\Support\Facades\Gate;
use Modules\FileHandler;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\StreamedResponse;


class FileController extends ApiController
{
    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function index()
    {
        Gate::authorize('viewAny-file');
        $files = File::all()->sortBy([['length', 'asc'], ['filename', 'asc']]);
        return response()->json($files);
    }

    /**
     * @throws AuthorizationException
     */
    public function indexRom(string $fileId)
    {
        $file = File::findOrFail($fileId);
        $this->authorize('view', $file);
        return response()->json(...$this->fileRepository->assocRom($file));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(string $fileId)
    {
        $file = File::findOrFail($fileId);
        $this->authorize('view', $file);
        return response()->json($file);
    }

    /**
     * @param string $fileId
     * @return StreamedResponse
     */
    public function download(string $fileId): StreamedResponse
    {
        $file = File::findOrFail($fileId);
        return response()->streamDownload(function () use ($fileId) {
            $this->fileRepository->downloadFile($fileId);
        }, $file['filename'], array(
            'Content-Type' => FileTypes::OCTET_STREAM->value,
            'Content-Transfer-Encoding' => 'chunked'
        ), disposition: 'attachment');
    }

    /**
     * @throws AuthorizationException
     */
    public function upload(StoreFileRequest $request): JsonResponse
    {
        $this->authorize('create', File::class);
        return response()->json($this->fileRepository->uploadFile($request->file(FILE_FORM_KEY)), ResponseAlias::HTTP_CREATED)
            ->header('X-Content-Transfer-Type', FileTypes::OCTET_STREAM->value);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $fileId): JsonResponse
    {
        $file = File::findOrFail($fileId);
        $this->authorize('delete', $file);
        return response()->json($this->fileRepository->deleteFile($fileId,$file));
    }
}
