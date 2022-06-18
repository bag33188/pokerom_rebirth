<?php

namespace App\Http\Requests;

use App\Models\Game;
use App\Rules\RequiredIfPutRequest;
use App\Rules\ValidGameName;
use App\Rules\ValidGameRegion;
use App\Rules\ValidGameType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin Game */
class UpdateGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $game = Game::findOrFail($this->game);
        return $this->user()->can('update', $game);
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
    #[ArrayShape(['game_name' => "string[]", 'date_released' => "string[]", 'game_type' => "array", 'region' => "array", 'generation' => "string[]"])]
    public function rules(): array
    {
        return [
            'game_name' => [new RequiredIfPutRequest($this), 'string', 'min:7', 'max:40', new ValidGameName],
            'date_released' => [new RequiredIfPutRequest($this), 'date'],
            'game_type' => [new RequiredIfPutRequest($this), 'string', 'min:4', 'max:8', new ValidGameType],
            'region' => [new RequiredIfPutRequest($this), 'string', 'min:4', 'max:8', new ValidGameRegion],
            'generation' => [new RequiredIfPutRequest($this), 'integer', 'min:0', 'max:9'],
        ];
    }
}
