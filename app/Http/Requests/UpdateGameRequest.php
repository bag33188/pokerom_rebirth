<?php

namespace App\Http\Requests;

use App\Actions\Validators\GameValidationRulesTrait;
use App\Models\Game;
use App\Rules\RequiredIfPutRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin Game */
class UpdateGameRequest extends FormRequest
{
    use GameValidationRulesTrait;

    private RequiredIfPutRequest $requiredIfPutRequest;

    public function __construct(RequiredIfPutRequest $requiredIfPutRequest)
    {
        $this->requiredIfPutRequest = $requiredIfPutRequest;
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $game = Game::findOrFail($this->getGameIdParamValue());
        return $this->user()->can('update', $game);
    }

    private function getGameIdParamValue(): object|string|null
    {
        return $this->route()->parameter('game') ?: $this->route()->parameter('id') ?: $this->route()->parameter('gameId');
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
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['game_name' => "array", 'date_released' => "array", 'game_type' => "array", 'region' => "array", 'generation' => "array"])]
    public function rules(): array
    {
        return [
            'game_name' => $this->gameNameRules([$this->requiredIfPutRequest]),
            'date_released' => $this->dateReleasedRules([$this->requiredIfPutRequest]),
            'game_type' => $this->gameTypeRules([$this->requiredIfPutRequest]),
            'region' => $this->gameRegionRules([$this->requiredIfPutRequest]),
            'generation' => $this->gameGenerationRules([$this->requiredIfPutRequest]),
        ];
    }
}
