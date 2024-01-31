<?php

namespace App\Exceptions\Backend\Authentication;

use Exception;

class Authentication extends Exception
{
    public function __construct($message = NULL, $statusCode = NULL)
    {
        parent::__construct($message, $statusCode);
    }
}
