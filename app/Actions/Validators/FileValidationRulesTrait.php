<?php

namespace App\Actions\Validators;

use App\Exceptions\UnsupportedRomTypeException;
use App\Rules\ValidFilename;

trait FileValidationRulesTrait
{
    private static string $fileTypesPattern = /** @lang RegExp */
        "/\.(gba|gbc|gb|nds|xci|3ds)$/i";

    /**
     * @throws UnsupportedRomTypeException
     */
    private static function checkForUnsupportedMediaType(string $filename): void
    {
        if (!preg_match(self::$fileTypesPattern, $filename)) {
            throw new UnsupportedRomTypeException($filename);
        }
    }

    /**
     * @throws UnsupportedRomTypeException
     */
    protected function fileRules(string $filename, array $rules = ['required']): array
    {
        self::checkForUnsupportedMediaType($filename);

        $fileRules = [];
        $fileRules[FILE_FORM_KEY] = array(
            ...$rules,
            new ValidFilename($filename),
        );
        return $fileRules;
    }
}
