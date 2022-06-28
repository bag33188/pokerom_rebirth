<?php

namespace App\Http\Livewire\Game;

use GameRepo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public $game;
    public $gameId;

    public function mount(int $gameId): void
    {
        $this->gameId = $gameId;
        $this->game = GameRepo::findGameIfExists($gameId);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.game.show');
    }

    public function edit(int $gameId)
    {
        $this->redirect(route('games.edit', ['gameId' => $gameId]));
    }
}
