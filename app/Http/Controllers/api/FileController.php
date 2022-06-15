<?php

namespace App\Http\Controllers\api;

use App\Enum\FileTypesEnum as FileTypes;
use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Illuminate\Support\Facades\Gate;
use Modules\FileDownloader;
use Modules\FileHandler;
use Symfony\Component\HttpFoundation\StreamedResponse;


class FileController extends ApiController
{
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
        $rom = $file->rom()->first();
        return response()->json($rom ??
            ['message' => 'no rom is associated with this file'],
            isset($rom) ? 200 : 404);
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
        $gridfs = new FileHandler();
        $stream = $gridfs->getDownloadStreamFromFile($fileId);
        return response()->streamDownload(function () use ($stream, $fileId) {
            $fileDownloader = new FileDownloader($stream, 0xFF000);
            $fileDownloader->downloadFile();
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
        $gridfs = new FileHandler();
        $gridfs->setUploadFileData($request->file(FILE_FORM_KEY));
        $gridfs->uploadFileFromStream();
        return response()->json(['message' => "file {$gridfs->getFilename()} created!"], 201)
            ->header('X-Content-Transfer-Type', FileTypes::OCTET_STREAM->value);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $fileId): JsonResponse
    {
        $file = File::findOrFail($fileId);
        $this->authorize('delete', $file);
        $gridfs = new FileHandler();
        $gridfs->deleteFileFromBucket($fileId);
        $file->delete(); //! <- keep this in order to invoke the policy method
        return response()->json(['message' => "{$file['filename']} deleted!"]);
    }
}
