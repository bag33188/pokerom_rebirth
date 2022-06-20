<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MongoBulkException extends ApplicationException
{
    protected int $statusCode = ResponseAlias::HTTP_CONFLICT;

    /**
     * @return string
     */
    public function viewName(): string
    {
        return 'errors.query-exception';
    }

    public function errorMessage(): string
    {
        return $this->getMessage();
    }
}
