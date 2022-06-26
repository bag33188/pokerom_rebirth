<?php

namespace App\Http\Livewire\Game;

use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use GameRepo;
use Livewire\Component;

class Edit extends Component
{
    public Game $game;
    private int $gameId;

    public function mount(int $gameId)
    {
        $this->gameId = $gameId;
        $this->game = GameRepo::findGameIfExists($gameId);
    }

    public function render()
    {
        return view('livewire.game.edit', ['gameId' => $this->gameId]);
    }

    public function update(UpdateGameRequest $request, int $gameId)
    {
        $this->game = GameRepo::findGameIfExists($gameId);
        $this->game->update($request->all());
        return redirect()->route('games.show', ['gameId' => $gameId])->banner('Game Updated successfully.');
    }
}
