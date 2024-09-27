<?php

namespace App\Exception;

use Throwable;
use Exception;

class DtoValidationException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct(
            message: 'Input data is not valid: ' . $message,
            code: $code,
            previous: $previous
        );
    }
}