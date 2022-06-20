<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class MongoBulkException extends Exception
{
    use ExceptionRender;

    private static string $viewName = 'errors.query-exception';
    private const CONFLICT = 409;

    public function __construct(string $message = "", int $code = self::CONFLICT, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render(Request $request): Response|JsonResponse
    {
        return self::renderException($this, $request, self::$viewName);
    }
}
