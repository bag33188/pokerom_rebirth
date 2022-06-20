<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SqlQueryException extends ApplicationException
{
    public function status(): int
    {
       return ResponseAlias::HTTP_CONFLICT;
    }

    public function viewName(): string
    {
        return 'errors.query-exception';
    }

    public function apiMessage(): string
    {
        return $this->getMessage();
    }
}
