<?php

namespace App\Exceptions;

use Utils\Classes\AbstractApplicationException as ApplicationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SqlQueryException extends ApplicationException
{
    public function status(): int
    {
       return ResponseAlias::HTTP_CONFLICT;
    }

    public function viewName(): ?string
    {
        return null;
    }

    public function errorMessage(): string
    {
        return $this->getMessage();
    }
}
