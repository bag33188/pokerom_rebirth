<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\StoreRomRequest;
use App\Http\Requests\UpdateRomRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\RomCollection;
use App\Http\Resources\RomResource;
use App\Models\Rom;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RomController extends ApiController
{
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
        $game = Rom::findOrFail($romId)->game()->firstOrFail();
        return new GameResource($game);
    }

    public function indexFile(int $romId)
    {
        Gate::authorize('viewAny-file');
        $file = Rom::findOrFail($romId)->file()->first();
        return response()->json($file ?? ['message' => 'this rom does not have a file'],
            isset($file) ? 200 : 404);
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
        $file = $rom->checkMatchingFile()->first();
        if (isset($file)) {
            DB::statement(/** @lang MariaDB */ "CALL LinkRomToFile(:fileId, :fileSize, :romId);", [
                'fileId' => $file['_id'],
                'fileSize' => $file->length,
                'romId' => $rom->id
            ]);
            $rom->refresh();
            return response()->json([
                'message' => "file found and linked! file id: {$file['_id']}",
                'data' => $rom->refresh()
            ]);

        }
        return response()->json(['message' => "File not found with name of {$rom->getRomFileName()}"], 404);
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
