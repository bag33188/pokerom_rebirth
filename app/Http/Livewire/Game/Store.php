<?php

namespace App\Http\Livewire\Game;

use Illuminate\Contracts\{Foundation\Application, View\Factory, View\View};
use Livewire\Component;

class Store extends Component
{
    public function render(): Factory|View|Application
    {
        return view('livewire.game.store');
    }
}
