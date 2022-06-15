<?php

namespace App\Http\Controllers\api;

use App\{Http\Controllers\Controller as ApiController,
    Http\Requests\StoreGameRequest,
    Http\Requests\UpdateGameRequest,
    Http\Resources\GameCollection,
    Http\Resources\GameResource,
    Models\Game,
    Models\Rom
};
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class GameController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return GameCollection
     */
    public function index()
    {
        $games = Game::all()->sortBy([
            ['rom_id', 'asc'],
            ['generation', 'asc']
        ]);
        return new GameCollection($games);
    }

    /**
     * @param int $gameId
     * @return JsonResponse
     */
    public function indexRom(int $gameId)
    {
        $rom = Game::findOrFail($gameId)->rom()->first();
        return response()->json($rom);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGameRequest $request
     * @return JsonResponse
     */
    public function store(StoreGameRequest $request): JsonResponse
    {
        $romId = $request->get('romId') ??
            throw new NotAcceptableHttpException(message: 'No ROM ID was sent.');
        // check if rom exists
        Rom::findOrFail($romId);
        $request['rom_id'] = $romId;
        $game = Game::create($request->all());
        $rom = Rom::find($romId);
        $game->rom()->associate($rom);
        $game->save();

        return response()->json($game, 201);
    }

    public function update(UpdateGameRequest $request, int $gameId): JsonResponse
    {
        $game = Game::findOrFail($gameId);
        $game->update($request->all());
        return response()->json($game);
    }

    public function show(int $gameId)
    {
        $game = Game::findOrFail($gameId);
        return new GameResource($game);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $gameId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $gameId): JsonResponse
    {
        $game = Game::findOrFail($gameId);
        $this->authorize('delete', $game);
        Game::destroy($gameId);
        return response()->json(['message' => "game $game->game_name deleted!"]);
    }
}
