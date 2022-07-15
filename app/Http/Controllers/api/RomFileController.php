<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreRomFileRequest;
use App\Http\Resources\RomFileCollection;
use App\Http\Resources\RomFileResource;
use App\Http\Resources\RomResource;
use App\Interfaces\Action\RomFileActionsInterface;
use App\Interfaces\Service\RomFileServiceInterface;
use App\Models\RomFile;
use DB;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Illuminate\Support\Facades\Gate;
use Request;
use Response;
use RomFileRepo;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;


class RomFileController extends ApiController
{
    public function __construct(private readonly RomFileServiceInterface $romFileService)
    {
    }

    /**
     * @throws AuthorizationException
     */
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
     * @throws AuthorizationException
     */
    public function listFilesInRomFilesStorage(RomFileActionsInterface $romFileActions): array
    {
        Gate::authorize('viewAny-romFile');

        return $romFileActions->listAllFilesInStorage();
    }

    /**
     * @return string[]
     * @throws AuthorizationException
     */
    public function listRomsInRomFilesStorage(RomFileActionsInterface $romFileActions): array
    {
        Gate::authorize('viewAny-romFile');

        return $romFileActions->listRomFilesInStorage();
    }

    /**
     * Connects to the `rom_files.info` collection from the `mongodb` connection.
     * Queries all the documents in collection.
     *
     * @throws AuthorizationException
     * @returns JsonResponse|null
     */
    public function getRomFileMetadata(): ?JsonResponse
    {
        Gate::authorize('viewAny-romFile');
        if (Request::acceptsJson()) {
            $columns = array('filename', 'filetype', 'filesize');
            $data = DB::connection('mongodb')->table('rom_files.info')->get($columns);
            return Response::json($data->chunk(10), HttpResponse::HTTP_OK);
        }
        return null;
    }
}
