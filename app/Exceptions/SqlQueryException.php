<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class SqlQueryException extends Exception
{
    use ExceptionRender;
    public function __construct(string $message = "", int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render(Request $request): Response|JsonResponse
    {
        return self::renderException($this, $request, 'errors.query-exception');
    }
}
