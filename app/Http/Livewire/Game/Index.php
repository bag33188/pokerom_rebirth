<?php

namespace App\Http\Livewire\Game;

use GameRepo;
use Livewire\Component;

class Index extends Component
{
    public $games;
    public function render()
    {
        $this->games = GameRepo::getAllGamesSorted();
        return view('livewire.game.index');
    }
}
