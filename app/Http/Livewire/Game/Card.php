<?php

namespace App\Http\Livewire\Game;

use App\Models\Game;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Card extends Component
{
    public Game $game;
    public int $index;

    public function render(): Factory|View|Application
    {
        return view('livewire.game.card');
    }

    /**
     * If the game's {@see Game::generation `generation`} property value is greater than `0`,
     * then convert the number into a roman numeral,
     * else return the value `0` as a string.
     *
     * @param int $generation min: `0`, max: `9`
     * @return string
     */
    public function parseGenerationIntoRomanWhenNotZero(int $generation): string
    {
        return $generation > 0 ? numberToRoman($generation) : strval(0);
    }
}
