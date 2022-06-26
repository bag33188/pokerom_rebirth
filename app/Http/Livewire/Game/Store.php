<?php

namespace App\Http\Livewire\Game;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Store extends Component
{
    public function render(): Factory|View|Application
    {
        return view('livewire.game.store');
    }

    public function getAvailableRoms(): array
    {
        // todo: implement toJson and arrayable
        $sql = /** @lang MariaDB */
            "CALL FindRomsWithNoGame()";
        return DB::select($sql);
    }
}
