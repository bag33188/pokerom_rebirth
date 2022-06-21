<?php

namespace App\Http\Requests;

use App\Actions\Validators\FileValidationRulesTrait;
use App\Exceptions\UnsupportedRomTypeException;
use App\Models\File;
use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    use FileValidationRulesTrait;

    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', File::class);
    }

    private function getFileNameIfExists(): string
    {
        $file = @$this[FILE_FORM_KEY] ?? null;
        return isset($file) ? @$file->getClientOriginalName() : "ERR_NO_FILENAME";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     * @throws UnsupportedRomTypeException
     */
    public function rules(): array
    {
        return $this->fileRules($this->getFileNameIfExists());
    }
}
