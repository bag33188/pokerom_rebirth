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
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class GameController extends ApiController
{
    private GameRepositoryInterface $gameRepository;
    private GameServiceInterface $gameService;

    public function __construct(GameRepositoryInterface $gameRepository, GameServiceInterface $gameService)
    {
        $this->gameRepository = $gameRepository;
        $this->gameService = $gameService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return GameCollection
     */
    public function index()
    {
        return new GameCollection($this->gameRepository->getAllGamesSorted());
    }

    /**
     * @param int $gameId
     * @return JsonResponse
     */
    public function indexRom(int $gameId)
    {
        return response()->json($this->gameRepository->getRomAssociatedWithGame($gameId));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGameRequest $request
     * @return JsonResponse
     */
    public function store(StoreGameRequest $request): JsonResponse
    {
        $game = Game::create($request->all());
        return response()->json($this->gameService->associateGameWithRom($game, $request['rom_id'])
            , ResponseAlias::HTTP_CREATED);
    }

    public function update(UpdateGameRequest $request, int $gameId): JsonResponse
    {
        $game = $this->gameRepository->findGameIfExists($gameId);
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
        $game = $this->gameRepository->findGameIfExists($gameId);
        $this->authorize('delete', $game);
        Game::destroy($gameId);
        return response()->json(['message' => "game $game->game_name deleted!"]);
    }
}
