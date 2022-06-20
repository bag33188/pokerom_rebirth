<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Pure;

trait ExceptionRender
{
    protected static function renderException(ApplicationException $exception, Request $request, string $viewName, string $apiMessage = null): Response|JsonResponse
    {
        if ($request->is('api/*')) {
            $error = new Error(error: $apiMessage);
            return response()->json($error, $exception->status());
        } else {
            return response()->view($viewName,
                ['message' => $exception->getMessage()], $exception->status());
        }
    }

    #[Pure]
    protected static function makeCustomMessage(Exception $exception, string $msg): string
    {
        return (strlen(@$exception->getMessage()) != 0) ? $exception->getMessage() : $msg;
    }
}
