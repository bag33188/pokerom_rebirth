<?php

namespace App\Http\Requests;

use App\Actions\GameValidationRules;
use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/** @mixin Game */
class StoreGameRequest extends FormRequest
{
    use GameValidationRules;

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
        $romId = $this->get('romId') ??
            throw new BadRequestHttpException(message: 'No ROM ID was sent.');
        $this->merge([
            'slug' => Str::slug($this->game_name),
            'rom_id' => $romId
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
            'game_name' => ['required', ...$this->gameNameRules()],
            'date_released' => ['required', ...$this->dateReleasedRules()],
            'game_type' => ['required', ...$this->gameTypeRules()],
            'region' => ['required', ...$this->gameRegionRules()],
            'generation' => ['required', ...$this->gameGenerationRules()],
        ];
    }
}
