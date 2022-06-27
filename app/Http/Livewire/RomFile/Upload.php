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
        $a= $request->file(FILE_FORM_KEY);
//        echo $a->getPathInfo();
//        echo $a->getFilename();
        GfsRomFile::upload($a);
        // todo: THIS WORKS!!!!!
        echo 'hi';
    }
}
