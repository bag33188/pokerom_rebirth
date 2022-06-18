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
    private RequiredIfPutRequest $requiredIfPutRequest;

    public function __construct(RequiredIfPutRequest $requiredIfPutRequest)
    {
        $this->$requiredIfPutRequest = $requiredIfPutRequest;
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $game = Game::findOrFail($this->getParameterValue());
        return $this->user()->can('update', $game);
    }

    private function getParameterName()
    {
        return $this->route()->parameterNames[0];
    }

    private function getParameterValue(): object|string|null
    {
        return $this->route()->parameter($this->getParameterName());
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
            'game_name' => [$this->requiredIfPutRequest, 'string', 'min:7', 'max:40', new ValidGameName],
            'date_released' => [$this->requiredIfPutRequest, 'date'],
            'game_type' => [$this->requiredIfPutRequest, 'string', 'min:4', 'max:8', new ValidGameType],
            'region' => [$this->requiredIfPutRequest, 'string', 'min:4', 'max:8', new ValidGameRegion],
            'generation' => [$this->requiredIfPutRequest, 'integer', 'min:0', 'max:9'],
        ];
    }
}
