<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class SqlQueryException extends Exception
{
    public function __construct(string $message = "", int $code = 406, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render(Request $request): Response|JsonResponse
    {
        if ($request->is('api/*')) {
            return response()->json(['message' => $this->getMessage()], $this->getCode());
        } else {
            return response()->view('errors.query-exception',
                ['message' => $this->getMessage()], $this->getCode());
        }
    }
}
