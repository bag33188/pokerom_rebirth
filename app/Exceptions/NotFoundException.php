<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

# use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class NotFoundException extends ApplicationException
{
    public function apiMessage(): string
    {
        return $this->makeCustomMessage("Error: requested endpoint not found.");
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
