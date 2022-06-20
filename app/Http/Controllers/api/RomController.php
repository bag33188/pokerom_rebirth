<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreRomRequest;
use App\Http\Requests\UpdateRomRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\RomCollection;
use App\Http\Resources\RomResource;
use App\Interfaces\RomRepositoryInterface;
use App\Interfaces\RomServiceInterface;
use App\Models\Rom;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class RomController extends ApiController
{
    private RomRepositoryInterface $romRepository;
    private RomServiceInterface $romService;

    public function __construct(RomRepositoryInterface $romRepository, RomServiceInterface $romService)
    {
        $this->romRepository = $romRepository;
        $this->romService = $romService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return RomCollection
     */
    public function index()
    {
        return new RomCollection($this->romRepository->getAllRomsSorted());
    }

    public function indexGame(int $romId)
    {
        return new GameResource($this->romRepository->getGameAssociatedWithRom($romId));
    }

    /**
     * @throws AuthorizationException
     */
    public function indexFile(int $romId)
    {
        Gate::authorize('viewAny-file');
        return response()->json($this->romRepository->getFileAssociatedWithRom($romId));
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

        return response()->json($rom);
    }

    /**
     * Display the specified resource.
     *
     * @param int $romId
     * @return RomResource
     */
    public function show(int $romId): RomResource
    {
        $rom = $this->romRepository->findRomIfExists($romId);
        return new RomResource($rom);
    }

    public function update(UpdateRomRequest $request, int $romId): JsonResponse
    {
        $rom = $this->romRepository->findRomIfExists($romId);
        $rom->update($request->all());
        return response()->json($rom);
    }

    /**
     * @throws AuthorizationException
     */
    public function linkRomToFile(int $romId)
    {
        $rom = $this->romRepository->findRomIfExists($romId);
        $this->authorize('update', $rom);
        $res = $this->romService->attemptToLinkRomToFile($rom);
        return response()->json($res->json, $res->code);
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
        $rom = $this->romRepository->findRomIfExists($romId);
        $this->authorize('delete', $rom);
        Rom::destroy($romId);
        return response()->json(['message' => "rom $rom->rom_name deleted!"]);
    }
}
