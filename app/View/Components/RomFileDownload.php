<?php

namespace App\View\Components;

use App\Models\RomFile;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RomFileDownload extends Component
{
    public RomFile $romFile;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(RomFile $romFile)
    {
        $this->romFile = $romFile;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string|Closure
     */
    public function render(): View|string|Closure
    {
        return view('components.rom-file-download');
    }
}
