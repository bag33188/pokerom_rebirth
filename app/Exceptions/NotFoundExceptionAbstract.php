<?php

namespace App\Exceptions;

use Utils\Classes\AbstractApplicationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

# use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class NotFoundExceptionAbstract extends AbstractApplicationException
{
    public function errorMessage(): string
    {
        return $this->makeCustomMessageIfDefaultIsNull("Error: requested endpoint not found.");
    }

    public function status(): int
    {
        return ResponseAlias::HTTP_NOT_FOUND;
    }

    public function viewName(): string
    {
        return 'errors.404';
    }
}
