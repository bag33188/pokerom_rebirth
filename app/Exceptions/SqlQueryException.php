<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SqlQueryException extends Exception
{
    public function render(Request $request): bool|JsonResponse|RedirectResponse
    {
        $isApiRequest = $request->is("api/*");
        $isLivewireRequest = $request->header('X-Livewire');
        if (!$isApiRequest && !$isLivewireRequest) {
            return redirect()->to(url()->previous())->dangerBanner($this->getMessage());
        }
        if ($isApiRequest) {
            return response()->json(['message' => $this->getMessage()], ResponseAlias::HTTP_CONFLICT);
        }
        return false;
    }
}
