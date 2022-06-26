<?php

namespace App\Http\Livewire\Game;

use App\Http\Requests\StoreGameRequest;
use App\Interfaces\GameDataServiceInterface;
use GameRepo;
use Illuminate\Contracts\{Foundation\Application, View\Factory, View\View};
use Livewire\Component;

class Create extends Component
{
    private array $availableRoms = [];
    private int $availableRomsCount = 0;


    public function mount()
    {
        $this->availableRoms = GameRepo::getAllRomsWithNoGame();
        $this->availableRomsCount = count($this->availableRoms);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.game.create', ['availableRoms' => $this->availableRoms, 'availableRomsCount' => $this->availableRomsCount]);
    }

    public function store(StoreGameRequest $request, GameDataServiceInterface $gameDataService) {
        $game = $gameDataService->createGameFromRomId((int)$request['rom_id'], $request->all());
        return redirect()->route('games.index')->banner("Game $game->game_name created successfully.");
    }
}
