<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

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
