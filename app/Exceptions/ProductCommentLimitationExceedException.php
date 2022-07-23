<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ProductCommentLimitationExceedException extends ClientException
{
    public function __construct(string $message = "Your limit on adding comment to this product is exceeded", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, Response::HTTP_CREATED, $previous);
    }
}
