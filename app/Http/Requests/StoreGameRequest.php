<?php

namespace App\Http\Requests;

use App\Models\Game;
use App\Rules\ValidGameName;
use App\Rules\ValidGameRegion;
use App\Rules\ValidGameType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/** @mixin Game */
class StoreGameRequest extends FormRequest
{
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
    #[ArrayShape(['game_name' => "string[]", 'date_released' => "string[]", 'game_type' => "array", 'region' => "array", 'generation' => "string[]"])]
    public function rules(): array
    {
        return [
            'game_name' => ['required', 'string', 'min:7', 'max:40', new ValidGameName],
            'date_released' => ['required', 'date'],
            'game_type' => ['required', 'string', 'min:4', 'max:8', new ValidGameType],
            'region' => ['required', 'string', 'min:4', 'max:8', new ValidGameRegion],
            'generation' => ['required', 'integer', 'min:0', 'max:9'],
        ];
    }
}
