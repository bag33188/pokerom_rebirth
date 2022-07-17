<?php

namespace App\Http\Livewire\Game;

use App\Models\Game;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Card extends Component
{
    public Game $game;

    public function render(): Factory|View|Application
    {
        return view('livewire.game.card');
    }

}
