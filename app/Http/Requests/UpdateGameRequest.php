<?php

namespace App\Http\Requests;

use App\Actions\GameValidationRules;
use App\Models\Game;
use App\Rules\RequiredIfPutRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin Game */
class UpdateGameRequest extends FormRequest
{
    use GameValidationRules;

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
        return $this->route()->parameter('game');
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
            'game_name' => [$this->requiredIfPutRequest, ...$this->gameNameRules()],
            'date_released' => [$this->requiredIfPutRequest, ...$this->dateReleasedRules()],
            'game_type' => [$this->requiredIfPutRequest, ...$this->gameTypeRules()],
            'region' => [$this->requiredIfPutRequest, ...$this->gameRegionRules()],
            'generation' => [$this->requiredIfPutRequest, ...$this->gameGenerationRules()],
        ];
    }
}
