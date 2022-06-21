<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\{StoreGameRequest, UpdateGameRequest};
use App\Http\Resources\{GameCollection, GameResource, RomResource};
use App\Interfaces\GameServiceInterface;
use App\Models\Game;
use GameRepo;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException;

class GameController extends ApiController
{
    private GameServiceInterface $gameDataService;

    public function __construct(GameServiceInterface $gameDataService)
    {
        $this->gameDataService = $gameDataService;
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
        return response()->json(new RomResource(GameRepo::getRomAssociatedWithGame($gameId)));
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
            throw new PreconditionRequiredHttpException(message: 'No ROM ID was sent.', code: ResponseAlias::HTTP_PRECONDITION_REQUIRED);
        return $this->gameDataService->createGame($romId, $request->all())->response();
    }

    public function update(UpdateGameRequest $request, int $gameId)
    {
        $game = GameRepo::findGameIfExists($gameId);
        $game->update($request->all());
        return new GameResource($game);
    }

    public function show(int $gameId): GameResource
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
