<?php

namespace App\View\Components;

use App\Enums\DisplayStateEnum;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use JetBrains\PhpStorm\ArrayShape;

class ShowHideButton extends Component
{
    public string $text;
    public DisplayStateEnum $initialState;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $text, DisplayStateEnum $initialState)
    {
        $this->initialState = $initialState;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        return view('components.show-hide-button', [
            'cloakData' => $this->getCloakData(),
            'alpineStates' => $this->getAlpineStates()
        ]);
    }

    #[ArrayShape(['initHide' => "string", 'initShow' => "string"])]
    private function getCloakData(): array
    {
        $initShow = match ($this->initialState) {
            DisplayStateEnum::HIDE => 'x-cloak',
            DisplayStateEnum::SHOW => ''
        };
        $initHide = match ($this->initialState) {
            DisplayStateEnum::HIDE => '',
            DisplayStateEnum::SHOW => 'x-cloak'
        };
        return ['initHide' => $initHide, 'initShow' => $initShow];
    }

    #[ArrayShape(['hidden' => "!open", 'shown' => "open"])]
    private function getAlpineStates(): array
    {
        return ['hidden' => DisplayStateEnum::HIDE->value, 'shown' => DisplayStateEnum::SHOW->value];
    }
}
