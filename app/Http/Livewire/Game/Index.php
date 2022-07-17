<?php

namespace App\Http\Livewire\Game;

use App\Models\Game;
use GameRepo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    /** @var Game[] */
    public $games;

    /** @var int */
    public $gamesCount;

    /** @var string[] */
    protected $listeners = ['show'];

    public function mount()
    {
        $this->games = GameRepo::getAllGamesSorted();
        $this->gamesCount = GameRepo::getGamesCount();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.game.index');
    }

    public function show(int $gameId)
    {
        $this->redirect(route('games.show', $gameId));
    }
}
