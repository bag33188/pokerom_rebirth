<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

# use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class NotFoundException extends ApplicationException
{
    protected int $statusCode = ResponseAlias::HTTP_NOT_FOUND;

    public function errorMessage(): string
    {
        return $this->makeCustomMessageIfDefaultIsNull("Error: requested endpoint not found.");
    }

    public function viewName(): string
    {
        return 'errors.404';
    }
}
