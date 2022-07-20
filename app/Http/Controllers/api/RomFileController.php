<?php

namespace App\Http\Controllers\API;

use App\Enums\FileContentTypeEnum as ContentType;
use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreRomFileRequest;
use App\Http\Resources\RomFileCollection;
use App\Http\Resources\RomFileResource;
use App\Http\Resources\RomResource;
use App\Interfaces\Service\RomFileServiceInterface;
use App\Models\RomFile;
use Gate;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse, Support\Collection};
use RomFileRepo;
use Symfony\Component\HttpFoundation\Response as HttpStatus;
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
     * Queries `rom_files.info` collection (mongodb)
     * @return Collection
     */
    public function indexMetadata(): Collection
    {
        Gate::authorize('viewAny-romFile');

        return RomFileRepo::getRomFilesMetadata();
    }

    /**
     * @throws AuthorizationException
     */
    public function show(string $romFileId): RomFileResource
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

        $uploadedRomFile = $this->romFileService->uploadRomFile($request['filename']);
        return response()->json(
            ['message' => "file '" . $uploadedRomFile->filename . "' created!", 'success' => true],
            HttpStatus::HTTP_CREATED,
            ['X-Content-Transfer-Type', ContentType::OCTET_STREAM->value]
        );
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $romFileId): JsonResponse
    {
        $romFile = RomFileRepo::findRomFileIfExists($romFileId);
        $this->authorize('delete', $romFile);
        $exec = $this->romFileService->deleteRomFile($romFile);
        return response()->json(
            ['message' => "file '" . $exec->filename . "' deleted!", 'success' => true],
            HttpStatus::HTTP_OK
        );
    }

    /**
     * @return string[]
     */
    public function listFilesInRomFilesStorage(): array
    {
        Gate::authorize('viewAny-romFile');

        return RomFileRepo::listAllFilesInStorage();
    }

    /**
     * @return string[]
     */
    public function listRomsInRomFilesStorage(): array
    {
        Gate::authorize('viewAny-romFile');

        return RomFileRepo::listRomFilesInStorage();
    }
}
