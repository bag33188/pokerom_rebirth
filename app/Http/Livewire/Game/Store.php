<?php

namespace App\Http\Livewire\Game;

use GameRepo;
use Illuminate\Contracts\{Foundation\Application, View\Factory, View\View};
use Livewire\Component;

class Store extends Component
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
        return view('livewire.game.store', ['availableRoms' => $this->availableRoms, 'availableRomsCount' => $this->availableRomsCount]);
    }
}
