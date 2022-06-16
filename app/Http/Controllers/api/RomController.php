<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreRomRequest;
use App\Http\Requests\UpdateRomRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\RomCollection;
use App\Http\Resources\RomResource;
use App\Interfaces\RomRepositoryInterface;
use App\Models\Rom;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RomController extends ApiController
{
    private RomRepositoryInterface $romRepository;

    public function __construct(RomRepositoryInterface $romRepository)
    {
        $this->romRepository = $romRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return RomCollection
     */
    public function index()
    {
        $roms = Rom::all()->sortBy([['game_id', 'asc'], ['rom_size', 'asc']]);
        return new RomCollection($roms);
    }

    public function indexGame(int $romId)
    {
        return new GameResource($this->romRepository->showGame($romId));
    }

    /**
     * @throws AuthorizationException
     */
    public function indexFile(int $romId)
    {
        Gate::authorize('viewAny-file');
        return response()->json($this->romRepository->showFile($romId));
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
        $rom = Rom::findOrFail($romId);
        return new RomResource($rom);
    }

    public function update(UpdateRomRequest $request, int $romId): JsonResponse
    {
        $rom = Rom::findOrFail($romId);
        $rom->update($request->all());
        return response()->json($rom);
    }

    /**
     * @throws AuthorizationException
     */
    public function linkRomToFile(int $romId)
    {
        $rom = Rom::findOrFail($romId);
        $this->authorize('update', $rom);
        return response()->json($this->romRepository->linkRomToFile($rom), ResponseAlias::HTTP_ACCEPTED);
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
        $rom = Rom::findOrFail($romId);
        $this->authorize('delete', $rom);
        Rom::destroy($romId);
        return response()->json(['message' => "rom {$rom->rom_name} deleted!"]);
    }
}
