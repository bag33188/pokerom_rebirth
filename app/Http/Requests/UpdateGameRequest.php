<?php

namespace App\Http\Requests;

use App\Http\Validators\GameValidationRulesTrait as GameValidationRules;
use App\Models\Game;
use App\Rules\RequiredIfPutRequest;
use Date;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin Game */
class UpdateGameRequest extends FormRequest
{
    use GameValidationRules;

    public function __construct(private readonly RequiredIfPutRequest $requiredIfPutRequest)
    {
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
        $routeParams = $this->route()->parameters();
        return
            $routeParams['game']
                ?: $routeParams['gameId']
                ?: $routeParams['id'];
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
            'date_released' => Date::create($this->date_released)
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
