<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreRomRequest;
use App\Http\Requests\UpdateRomRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\RomCollection;
use App\Http\Resources\RomFileResource;
use App\Http\Resources\RomResource;
use App\Interfaces\Service\RomServiceInterface;
use App\Models\Rom;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use RomRepo;
use Symfony\Component\HttpFoundation\Response as HttpStatus;

class RomController extends ApiController
{
    public function __construct(private readonly RomServiceInterface $romService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return RomCollection
     */
    public function index(): RomCollection
    {
        return new RomCollection(RomRepo::getAllRomsSorted());
    }

    public function indexGame(int $romId): GameResource
    {
        return new GameResource(RomRepo::getGameAssociatedWithRom($romId));
    }

    public function indexRomFile(int $romId): RomFileResource
    {
        Gate::authorize('viewAny-romFile');
        return new RomFileResource(RomRepo::getRomFileAssociatedWithRom($romId));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRomRequest $request
     * @return JsonResponse
     */
    public function store(StoreRomRequest $request): JsonResponse
    {
        $rom = Rom::create($request->all());

        return (new RomResource($rom))->response()->setStatusCode(HttpStatus::HTTP_CREATED);
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

    public function update(UpdateRomRequest $request, int $romId): RomResource
    {
        $rom = RomRepo::findRomIfExists($romId);
        $rom->update($request->all());
        return new RomResource($rom);
    }

    /**
     * @throws AuthorizationException
     */
    public function linkRomToRomFile(int $romId): JsonResponse
    {
        $rom = RomRepo::findRomIfExists($romId);
        $this->authorize('update', $rom);
        $exec = $this->romService->linkRomToRomFileIfExists($rom);
        if ($exec !== false) {
            $rom->refresh();
            return response()->json([
                'message' => "file found and linked! file id: " . $rom->romFile->_id,
                'data' => $rom,
                'success' => true
            ], HttpStatus::HTTP_OK);
        } else {
            return response()->json([
                'message' => "File not found with name of {$rom->getRomFileName()}",
                'success' => false
            ], HttpStatus::HTTP_NOT_FOUND);
        }
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
        return response()->json(['message' => "rom $rom->rom_name deleted!", 'success'=>true], HttpStatus::HTTP_OK);
    }
}
