<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class MongoBulkException extends ApplicationException
{
    use ExceptionRender;

    private static string $viewName = 'errors.query-exception';

    /**
     * @return string
     */
    public function viewName(): string
    {
        return self::$viewName;
    }

    public function status():int{
        return Response::HTTP_CONFLICT;
    }

    public function apiMessage(): ?string
    {
        return $this->getMessage();
    }
}
