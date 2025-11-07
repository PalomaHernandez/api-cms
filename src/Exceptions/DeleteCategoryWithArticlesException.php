<?php

namespace App\Exceptions;

class DeleteCategoryWithArticlesException extends \Exception
{
    public function __construct(string $message, int $code = 0)
    {
        parent::__construct($message, $code);
    }
}