<?php

namespace App\Http\Livewire\Game;

use GameRepo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public $games;

    public function render(): Factory|View|Application
    {
        $this->games = GameRepo::getAllGamesSorted();
        return view('livewire.game.index');
    }
}
