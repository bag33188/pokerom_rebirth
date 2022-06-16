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
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
        return response()->json($this->gameRepository->showAssociatedRom($gameId));
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
            throw new BadRequestHttpException(message: 'No ROM ID was sent.');
        $request['rom_id'] = $romId;
        $game = Game::create($request->all());
        $rom = $game->rom()->first();
        return response()->json($this->gameService->associateGameWithRom($rom)
            , ResponseAlias::HTTP_CREATED);
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
