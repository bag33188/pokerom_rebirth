<?php

namespace Utils\Classes;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

abstract class AbstractApplicationException extends Exception
{
    protected static function isApiRequest(Request $request): bool
    {
        return $request->is("api/*");
    }

    protected static function isLivewireRequest(Request $request): bool
    {
        $livewireHttpHeader = $request->header('X-Livewire');
        return isset($livewireHttpHeader);
    }

    abstract public function render(Request $request): bool|JsonResponse|RedirectResponse;
}
