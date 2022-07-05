<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MongoWriteException extends Exception
{
    public function render(Request $request)
    {
        if (!$request->is("api/*") && !$request->header('X-Livewire')) {
            return redirect()->to(url()->previous())->dangerBanner($this->getMessage());
        }
        if ($request->is("api/*")) {
            return response()->json(['message' => $this->getMessage()], ResponseAlias::HTTP_CONFLICT);
        }
    }
}
