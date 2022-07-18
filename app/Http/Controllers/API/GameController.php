<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as ApiController;
use App\Http\Requests\{StoreGameRequest, UpdateGameRequest};
use App\Http\Resources\{GameCollection, GameResource, RomResource};
use App\Interfaces\Service\GameServiceInterface;
use App\Models\Game;
use GameRepo;
use Illuminate\{Auth\Access\AuthorizationException, Http\JsonResponse};
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException;

class GameController extends ApiController
{
    /** @var string[] */
    private static array $queryParamNames = ['romId'];

    public function __construct(private readonly GameServiceInterface $gameService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return GameCollection
     */
    public function index(): GameCollection
    {
        return new GameCollection(GameRepo::getAllGamesSorted());
    }

    /**
     * @param int $gameId
     * @return RomResource
     */
    public function indexRom(int $gameId): RomResource
    {
        return new RomResource(GameRepo::getRomAssociatedWithGame($gameId));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGameRequest $request
     * @return JsonResponse
     */
    public function store(StoreGameRequest $request): JsonResponse
    {
        $romId = $request->query(self::$queryParamNames[0]);

        if (empty($romId)) {
            throw new PreconditionRequiredHttpException(
                message: 'No ROM ID was sent.',
                code: HttpResponse::HTTP_PRECONDITION_REQUIRED
            );
        }

        $game = $this->gameService->createGameFromRomId($romId, $request->all());
        return (new GameResource($game))->response()->setStatusCode(HttpResponse::HTTP_CREATED);
    }

    public function update(UpdateGameRequest $request, int $gameId): GameResource
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
        return jsonData(['message' => "game $game->game_name deleted!"], HttpResponse::HTTP_OK);
    }
}
