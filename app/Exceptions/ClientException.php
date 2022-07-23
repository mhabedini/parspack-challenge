<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class ClientException extends \Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['message' => $this->message], $this->code);
    }
}
