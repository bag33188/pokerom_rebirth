<?php

namespace App\Http\Livewire\RomFile;

use GfsRomFile;
use Illuminate\Http\Request;
use Livewire\Component;

class Upload extends Component
{
    public function render()
    {
        return view('livewire.rom-file.upload');
    }

    public function upload(Request $request)
    {
        // TODO:  implement better file upload
        //https://laracasts.com/discuss/channels/laravel/advice-on-solutions-for-very-large-file-uploads?page=1&replyId=774409
        //https://github.com/pionl/laravel-chunk-upload
        //https://github.com/23/resumable.js
        $a = $request->file(FILE_FORM_KEY);
        GfsRomFile::upload($a);
        echo 'hi';
    }
}
