<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListGroup extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|string|Closure
    {
        return /** @lang InjectablePHP */ <<<'blade'
            @php
                $listGroupClasses = [
                    'bg-white', 'rounded-lg', 'border',
                    'border-gray-200', 'text-gray-900', 'col-span-full',
                    'row-start-1', 'row-end-1'
                 ];
            @endphp
            <ul {{ $attributes->merge(['class' => joinHtmlClasses($listGroupClasses)]) }}>
                {{ $slot }}
            </ul>
        blade. "\n";
    }
}
