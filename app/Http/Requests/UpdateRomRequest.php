<?php

namespace App\Http\Requests;

use App\Actions\Validators\RomValidationRulesTrait;
use App\Models\Rom;
use App\Rules\RequiredIfPutRequest;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin Rom */
class UpdateRomRequest extends FormRequest
{
    use RomValidationRulesTrait;


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
        $rom = Rom::findOrFail($this->getRomIdParamValue());
        return $this->user()->can('update', $rom);
    }

    private function getRomIdParamValue(): object|string|null
    {
        if ($this->is("api/*")) {
            return $this->route()->parameter('romId');
        } else {
            return $this->route()->parameter('rom');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['rom_name' => "array", 'rom_type' => "array", 'rom_size' => "array"])]
    public function rules(): array
    {
        return [
            'rom_name' => $this->romNameRules([$this->requiredIfPutRequest]),
            'rom_type' => $this->romTypeRules([$this->requiredIfPutRequest]),
            'rom_size' => $this->romSizeRules([$this->requiredIfPutRequest]),
        ];
    }
}
