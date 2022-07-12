<?php

namespace App\Http\Requests;

use App\Http\Validators\GameValidationRulesTrait;
use App\Models\Game;
use Date;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin Game */
class StoreGameRequest extends FormRequest
{
    use GameValidationRulesTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Game::class);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->game_name),
            'date_released' => Date::create($this->date_released),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['game_name' => "array", 'date_released' => "array", 'game_type' => "array", 'region' => "array", 'generation' => "array"])]
    public function rules(): array
    {
        return [
            'game_name' => $this->gameNameRules(),
            'date_released' => $this->dateReleasedRules(),
            'game_type' => $this->gameTypeRules(),
            'region' => $this->gameRegionRules(),
            'generation' => $this->gameGenerationRules(),
        ];
    }
}
