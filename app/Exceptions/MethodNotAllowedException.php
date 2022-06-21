<?php

namespace App\Exceptions;

use Classes\ApplicationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MethodNotAllowedException extends ApplicationException
{

    protected function status(): int
    {
        return ResponseAlias::HTTP_METHOD_NOT_ALLOWED;
    }

    protected function viewName(): ?string
    {
        return null;
    }

    protected function errorMessage(): string
    {
        return $this->getMessage();
    }
}
