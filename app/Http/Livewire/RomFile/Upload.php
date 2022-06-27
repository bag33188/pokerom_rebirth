<?php

namespace App\Http\Livewire\RomFile;

use Illuminate\Http\Request;
use Livewire\Component;
use GfsRomFile;

class Upload extends Component
{
    public function render()
    {
        return view('livewire.rom-file.upload');
    }

    public function upload(Request $request) {
        //https://github.com/23/resumable.js
        $a= $request->file(FILE_FORM_KEY);
        GfsRomFile::upload($a);
        echo 'hi';
    }
}
