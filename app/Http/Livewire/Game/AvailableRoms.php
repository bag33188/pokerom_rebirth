<?php

namespace App\Http\Livewire\Game;

use App\Models\Rom;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class AvailableRoms extends Component
{
    public  $rom;
    public function render()
    {
        return view('livewire.game.available-roms');
    }
}
