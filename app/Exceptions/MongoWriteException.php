<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Utils\Classes\AbstractApplicationException as ApplicationException;

class MongoWriteException extends ApplicationException
{
    public function render(Request $request): false|JsonResponse|RedirectResponse
    {
        if (!$this->isApiRequest() && !$this->isLivewireRequest()) {
            return redirect()->to(url()->previous())->dangerBanner($this->getMessage());
        }
        if ($this->isApiRequest() || $request->acceptsJson()) {
            return response()->json(['message' => $this->getMessage()], $this->getCode());
        }
        return false;
    }

    public function report(): ?bool
    {
        return false;
    }
}
