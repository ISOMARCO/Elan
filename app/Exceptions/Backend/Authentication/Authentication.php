<?php

namespace App\Exceptions\Backend\Authentication;

use Exception;

class Authentication extends Exception
{
    public function __construct($message = null, $statusCode = null)
    {
        //parent::__construct($message, $statusCode);
    }
}
