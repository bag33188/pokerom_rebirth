<?php

namespace App\View\Components;

use App\Enums\DisplayStateEnum as AlpineDisplayState;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use JetBrains\PhpStorm\ArrayShape;

class ShowHideButton extends Component
{
    public string $text;
    public AlpineDisplayState $initialState;

    private const alpineStatesShape = ['hidden' => "!open", 'shown' => "open"];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $text, AlpineDisplayState $initialState)
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
            AlpineDisplayState::HIDE => 'x-cloak',
            AlpineDisplayState::SHOW => ''
        };
        $initHide = match ($this->initialState) {
            AlpineDisplayState::HIDE => '',
            AlpineDisplayState::SHOW => 'x-cloak'
        };
        return array('initHide' => $initHide, 'initShow' => $initShow);
    }

    #[ArrayShape(self::alpineStatesShape)]
    private function getAlpineStates(): array
    {
        return ['hidden' => AlpineDisplayState::HIDE->value, 'shown' => AlpineDisplayState::SHOW->value];
    }
}
