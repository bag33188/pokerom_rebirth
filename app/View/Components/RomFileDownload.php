<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RomFileDownload extends Component
{
    public string $romFileId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $romFileId)
    {
        $this->romFileId = $romFileId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('components.rom-file-download');
    }
}
