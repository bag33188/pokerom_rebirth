<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as RenderableView;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return Application|Factory|RenderableView|View
     */
    public function render(): RenderableView|Factory|View|Application
    {
        return view('layouts.app');
    }
}
