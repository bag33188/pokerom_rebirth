<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreRomRequest;
use App\Http\Requests\UpdateRomRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\RomCollection;
use App\Http\Resources\RomFileResource;
use App\Http\Resources\RomResource;
use App\Interfaces\Service\RomDataServiceInterface;
use App\Models\Rom;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use RomRepo;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RomController extends ApiController
{
    private RomDataServiceInterface $romDataService;

    public function __construct(RomDataServiceInterface $romDataService)
    {
        $this->romDataService = $romDataService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return RomCollection
     */
    public function index()
    {
        return new RomCollection(RomRepo::getAllRomsSorted());
    }

    public function indexGame(int $romId)
    {
        return new GameResource(RomRepo::getGameAssociatedWithRom($romId));
    }

    /**
     * @throws AuthorizationException
     */
    public function indexFile(int $romId)
    {
        Gate::authorize('viewAny-romFile');
        return new RomFileResource(RomRepo::getFileAssociatedWithRom($romId));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRomRequest $request
     * @return JsonResponse
     */
    public function store(StoreRomRequest $request)
    {
        $rom = Rom::create($request->all());

        return (new RomResource($rom))->response()->setStatusCode(ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $romId
     * @return RomResource
     */
    public function show(int $romId): RomResource
    {
        $rom = RomRepo::findRomIfExists($romId);
        return new RomResource($rom);
    }

    public function update(UpdateRomRequest $request, int $romId)
    {
        $rom = RomRepo::findRomIfExists($romId);
        $rom->update($request->all());
        return new RomResource($rom);
    }

    /**
     * @throws AuthorizationException
     */
    public function linkRomToFile(int $romId)
    {
        $rom = RomRepo::findRomIfExists($romId);
        $this->authorize('update', $rom);
        return $this->romDataService->attemptToLinkRomToFile($rom)->renderResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $romId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $romId): JsonResponse
    {
        $rom = RomRepo::findRomIfExists($romId);
        $this->authorize('delete', $rom);
        Rom::destroy($romId);
        return jsondata(['message' => "rom $rom->rom_name deleted!"], ResponseAlias::HTTP_OK);
    }
}
