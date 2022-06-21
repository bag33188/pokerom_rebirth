<?php

namespace App\Exceptions;

use Utils\Classes\AbstractApplicationException as ApplicationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MongoBulkException extends ApplicationException
{
    /**
     * @return string
     */
    public function viewName(): string
    {
        return 'errors.query-exception';
    }

    public function status(): int
    {
        return ResponseAlias::HTTP_CONFLICT;
    }

    public function errorMessage(): string
    {
        return $this->getMessage();
    }
}
