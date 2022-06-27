<?php

namespace App\Http\Livewire\RomFile;

use Illuminate\Http\Request;
use Livewire\Component;

class Upload extends Component
{
    public function render()
    {
        return view('livewire.rom-file.upload');
    }

    public function upload(Request $request) {
        $a= $request->file(FILE_FORM_KEY);
        // todo: THIS WORKS!!!!!
        echo $a->getClientOriginalName();
    }
}
