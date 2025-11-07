<?php

namespace App\Exceptions;

class InvalidTokenException extends \Exception
{

    public function __construct(?string $message = null) {
        parent::__construct($message ?? "Invalid token", 403);
    }

}