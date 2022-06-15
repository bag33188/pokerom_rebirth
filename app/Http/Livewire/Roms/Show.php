<?php

namespace App\Http\Livewire\Roms;

use App\Models\Rom;
use Livewire\Component;

class Show extends Component
{
    public $roms;

    public function render()
    {
        $this->roms = Rom::with(['game', 'file'])->get();
        return view('livewire.roms.show');
    }
}
