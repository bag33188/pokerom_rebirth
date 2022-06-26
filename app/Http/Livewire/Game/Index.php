<?php

namespace App\Http\Livewire\Game;

use GameRepo;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $games;
    public function render()
    {
        $this->games = GameRepo::getAllGamesSorted();
        return view('livewire.game.index');
    }

    public function getProperGameType(string $gameType) {
        $sql = "SELECT GetProperGameType(?) as gameType;";
        return DB::selectOne($sql, [$gameType])->gameType;
    }
}
