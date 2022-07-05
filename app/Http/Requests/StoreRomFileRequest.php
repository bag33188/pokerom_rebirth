<?php

namespace App\Http\Requests;

use App\Actions\Validators\RomFileValidationRulesTrait;
use App\Models\RomFile;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use Utils\Modules\FileMethods;

/** @mixin RomFile */
class StoreRomFileRequest extends FormRequest
{
    use RomFileValidationRulesTrait;

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

    protected function prepareForValidation(): void
    {
        $romFilename = $this->filename;
        FileMethods::normalizeFileName($romFilename);
        $this->merge([
            'filename' => $romFilename,
        ]);
    }

    #[ArrayShape(['filename' => "array"])]
    public function rules(): array
    {
        return [
            'filename' => $this->romFilenameRules()
        ];
    }
}
