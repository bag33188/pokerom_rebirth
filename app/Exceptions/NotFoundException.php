<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;


# use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class NotFoundException extends ApplicationException
{
    use ExceptionRender {
        ExceptionRender::makeCustomMessage as makeMessage;
    }

    public function apiMessage(): string
    {
        return self::makeMessage($this, "Error: requested endpoint not found.");
    }
    public function status(): int
    {
        return ResponseAlias::HTTP_NOT_FOUND;
    }
    public function viewName(): string
    {
        return  'errors.404';
    }
}
