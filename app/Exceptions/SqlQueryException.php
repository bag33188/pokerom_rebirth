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

    private static string $viewName = 'errors.query-exception';
    private const BAD_REQUEST = 400;

    public function __construct(string $message = "", int $code = self::BAD_REQUEST, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render(Request $request): Response|JsonResponse
    {
        return self::renderException($this, $request, self::$viewName);
    }
}
