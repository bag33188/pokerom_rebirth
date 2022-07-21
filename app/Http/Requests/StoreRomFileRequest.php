<?php

namespace App\Http\Requests;

use App\Http\Validators\RomFileValidationRulesTrait as RomFileValidationRules;
use App\Models\RomFile;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

/** @mixin RomFile */
class StoreRomFileRequest extends FormRequest
{
    use RomFileValidationRules;

    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', RomFile::class);
    }

    #[ArrayShape(['rom_filename' => "array"])]
    public function rules(): array
    {
        return [
            'rom_filename' => $this->romFilenameRules()
        ];
    }
}
