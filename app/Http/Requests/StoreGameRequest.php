<?php

namespace App\Http\Requests;

use App\Models\Game;
use App\Rules\MaxLength;
use App\Rules\MinLength;
use App\Rules\MinSize;
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
            'game_name' => ['required', 'string', new MinLength(MIN_GAME_NAME), new MaxLength(MAX_GAME_NAME), new ValidGameName],
            'date_released' => ['required', 'date'],
            'game_type' => ['required', 'string', new MinLength(MIN_GAME_TYPE), new MaxLength(MAX_GAME_TYPE), new ValidGameType],
            'region' => ['required', 'string', new MinLength(MIN_GAME_REGION), new MaxLength(MAX_GAME_REGION), new ValidGameRegion],
            'generation' => ['required', 'integer', new MinSize(MIN_GAME_GENERATION), new MaxLength(MAX_GAME_GENERATION)],
        ];
    }
}
