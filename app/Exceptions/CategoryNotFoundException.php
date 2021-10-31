<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class CategoryNotFoundException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['message' => $this->getMessage()], 400);
    }
}
