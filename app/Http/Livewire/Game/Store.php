<?php

namespace App\Http\Livewire\Game;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Store extends Component
{
    public function render(): Factory|View|Application
    {
        return view('livewire.game.store');
    }
}
