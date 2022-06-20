<?php

namespace App\Http\Controllers\api;

use App\{Http\Controllers\Controller as ApiController,
    Http\Requests\StoreGameRequest,
    Http\Requests\UpdateGameRequest,
    Http\Resources\GameCollection,
    Http\Resources\GameResource,
    Interfaces\GameRepositoryInterface,
    Interfaces\GameServiceInterface,
    Models\Game
};
use GameRepo;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;

class GameController extends ApiController
{
    private GameServiceInterface $gameService;

    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return GameCollection
     */
    public function index()
    {
        return new GameCollection(GameRepo::getAllGamesSorted());
    }

    /**
     * @param int $gameId
     * @return JsonResponse
     */
    public function indexRom(int $gameId)
    {
        return response()->json(GameRepo::getRomAssociatedWithGame($gameId));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGameRequest $request
     * @return JsonResponse
     */
    public function store(StoreGameRequest $request): JsonResponse
    {
        $romId = $request->query('romId') ??
            throw new PreconditionFailedHttpException(message: 'No ROM ID was sent.', code: 412);
        $res = $this->gameService->createGame($romId, $request->all());
        return response()->json(
            $res->json,
            $res->code);
    }

    public function update(UpdateGameRequest $request, int $gameId): JsonResponse
    {
        $game = GameRepo::findGameIfExists($gameId);
        $game->update($request->all());
        return response()->json($game);
    }

    public function show(int $gameId)
    {
        return new GameResource(GameRepo::findGameIfExists($gameId));
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
        $game = GameRepo::findGameIfExists($gameId);
        $this->authorize('delete', $game);
        Game::destroy($gameId);
        return response()->json(['message' => "game $game->game_name deleted!"]);
    }
}
