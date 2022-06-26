<?php

namespace App\Http\Livewire\Game;

use Livewire\Component;

class Show extends Component
{
    private $game;
    private int $gameId;

    public function mount(int $gameId)
    {
        $this->gameId = $gameId;
        $this->game = \GameRepo::findGameIfExists($gameId);
    }

    public function render()
    {
        return view('livewire.game.show', ['game' => $this->game, 'gameId' => $this->gameId]);
    }
}
