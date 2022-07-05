<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Utils\Classes\AbstractApplicationException as ApplicationException;

class SqlQueryException extends ApplicationException
{
    public function render(Request $request): bool|JsonResponse|RedirectResponse
    {
        if (!self::isApiRequest($request) && !self::isLivewireRequest($request)) {
            return redirect()->to(url()->previous())->dangerBanner($this->getMessage());
        }
        if (self::isApiRequest($request)) {
            return response()->json(['message' => $this->getMessage()], ResponseAlias::HTTP_CONFLICT);
        }
        return false;
    }
}
