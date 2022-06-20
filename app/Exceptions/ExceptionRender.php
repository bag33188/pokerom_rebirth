<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Pure;

trait ExceptionRender
{
    protected static function renderException(Exception $exception, Request $request, string $viewName, string $apiMessage = null): Response|JsonResponse
    {
        if ($request->is('api/*')) {
            return response()->json(['message' => $apiMessage ?? $exception->getMessage()], $exception->getCode());
        } else {
            return response()->view($viewName,
                ['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    #[Pure]
    protected static function makeCustomMessage(Exception $exception, string $msg): string
    {
        return strlen($exception->getMessage()) !== 0 ? $exception->getMessage() : $msg;
    }
}
