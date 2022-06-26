<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormSelect extends Component
{
    private string $htmlId;
    private string $elementName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $htmlId, string $elementName)
    {
        $this->htmlId = $htmlId;
        $this->elementName = $elementName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure
    {
        return view('components.form-select', ['htmlId' => $this->htmlId, 'elementName' => $this->elementName]);
    }
}
