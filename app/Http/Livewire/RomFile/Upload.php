<?php

namespace App\Http\Livewire\RomFile;

use GfsRomFile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Livewire\Component;

class Upload extends Component
{
    public function render(): Factory|View|Application
    {
        return view('livewire.rom-file.upload');
    }

    public function upload(Request $request): RedirectResponse
    {
        // TODO:  implement better file upload
        //https://laracasts.com/discuss/channels/laravel/advice-on-solutions-for-very-large-file-uploads?page=1&replyId=774409
        //https://github.com/pionl/laravel-chunk-upload
        //https://github.com/23/resumable.js
        $file = $request->file(FILE_FORM_KEY);
        GfsRomFile::upload($file);
        return redirect()->to(url()->previous())->banner("file uploaded!");
    }
}
