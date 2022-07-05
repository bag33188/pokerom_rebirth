<?php

namespace App\View\Components;

use App\Models\RomFile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RomFileDownload extends Component
{
    public RomFile $romFile;
    public bool $usePopupButtonStyle;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(RomFile $romFile, bool $usePopupButtonStyle = false)
    {
        $this->romFile = $romFile;
        $this->usePopupButtonStyle = $usePopupButtonStyle;
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