<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UnsupportedRomTypeException extends ApplicationException
{
    public function status(): int
    {
        return ResponseAlias::HTTP_UNSUPPORTED_MEDIA_TYPE;
    }

    public function help(): string
    {
        return 'no rommfds';
    }

    public function error(): string
    {
        return 'bebe';
    }
}
